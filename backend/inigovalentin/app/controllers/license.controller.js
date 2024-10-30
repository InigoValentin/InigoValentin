/**
 * @file Provides the model and operation for licenses.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')()
const db = require("../models");
const License = db.licenses;
const Op = db.Sequelize.Op;
const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService(db);

/**
 * Create and save a new license.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = (req, res) => {
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    // Validate request
    let missing = [];
    if (!req.body.name) missing.push("name");
    if (!req.body.summary) missing.push("summary");
    if (!req.body.legal) missing.push("legal");
    if (missing.length > 0){
        let message = "Missing required fields: [";
        for (let i = 0; i < missing.length; i ++){
            message += missing[i];
            if (i < missing.length - 1) message += ", ";
        }
        message += "].";
        res.status(400).send(message);
        return;
    }
    const name = req.body.name;
    const nameDb = name.toUpperCase().replace(/[^A-Z0-9]+/g, "");
    const summary = localeService.generateLocalizedObject(req.body.summary, "LICENSE_" + nameDb + "_SUMMARY", "DB_PROJECT");
    if (summary.valid === false){
        res.status(400).send("Invalid summary values");
        return;
    }
    const legal = localeService.generateLocalizedObject(req.body.legal, "LICENSE_" + nameDb + "_LEGAL", "DB_PROJECT");
    if (legal.valid === false){
        res.status(400).send("Invalid legal values");
        return;
    }
    localeService.saveLocalizedObject(summary);
    localeService.saveLocalizedObject(legal);
    // Create a License
    const License = {name: name, summary: summary, legal: legal, icon: icon};
    License.create(License)
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error creating license: " + err);
        res.status(500).send({"Error creating license."});
    });
};

/**
 * Retrieve all licenses from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    License.findAll()
    .then(async data => {
        data = await localeService.localizeLicenses(data, req);
        res.send(data);
    })
    .catch(err => {
        logger.error("Error retrieving projects: " + err);
        res.status(500).send("Error retrieving projects.");
    });
};

/**
 * Find a single license by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    License.findByPk(id)
    .then(async data => {
        if (data) {
            data = await localeService.localizeLicense(data, req);
            res.send(data);
        }
        else res.status(404).send(`No licenses with id ${id}.`});
    })
    .catch(err => {
        logger.error("Error retrieving license with id " + id + ": " + err);
        res.status(500).send("Error retrieving license with id " + id + ".");
    });
};

/**
 * Update a single license by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.update = (req, res) => {
    const id = req.params.id;
    License.update(req.body, {where: {id: id}})
    .then(num => {
        if (num == 1) res.send({message: "License was updated successfully."});
        else res.send({message: `Cannot update License with id=${id}. Maybe License was not found or req.body is empty!`});
    })
    .catch(err => {res.status(500).send({message: "Error updating License with id=" + id});});
};

/**
 * Delete a single license by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.delete = (req, res) => {
    const id = req.params.id;
    License.destroy({where: {id: id}})
    .then(num => {
        if (num == 1) res.send({message: "License was deleted successfully!"});
        else res.send({message: `Cannot delete License with id=${id}. Maybe License was not found!`});
    })
    .catch(err => {res.status(500).send({message: "Could not delete License with id=" + id});});
};

/**
 * Delete all licenses.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {
    License.destroy({
        where: {},
        truncate: false
    })
    .then(nums => {res.send({ message: `${nums} Licenses were deleted successfully!` });})
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while removing all Licenses."});});
};
