/**
 * @file Provides the model and operation for licenses.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const db = require("../models");
const License = db.licenses;
const Op = db.Sequelize.Op;

const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService(db);

/**
 * Create and Save a new license.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = (req, res) => {
    // Validate request
    if (!req.body.title) {
        res.status(400).send({message: "Content can not be empty!"});
        return;
    }
    
    // Create a License
    const License = {
        title: req.body.title,
        description: req.body.description,
        published: req.body.published ? req.body.published : false
    };
    
    // Save License in the database
    License.create(License)
    .then(data => {res.send(data);})
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while creating the License."});});
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
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while retrieving Licenses."});});
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
        else res.status(404).send({message: `Cannot find License with id=${id}.`});}
    })
    .catch(err => {res.status(500).send({message: "Error retrieving License with id=" + id});});
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
