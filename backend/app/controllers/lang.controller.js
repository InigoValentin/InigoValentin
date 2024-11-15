/**
 * @file Provides the model and operation for languages.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')()
const db = require("../models");
const Lang = db.langs;
const Op = db.Sequelize.Op;
const AuthService = require("../services/auth.service.js");
const authService = new AuthService(db);

/**
 * Create and save a new language.
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
    if (!req.body.code) missing.push("code");
    if (!req.body.name) missing.push("name");
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
    const code = req.body.code;
    const name = req.body.name;
    const priority = !isNaN(req.body.priority) ? Number(req.body.priority) : 99;
    const active = ((req.body.active + "").toLowerCase() === 'true') ? true : false;
    // TODO: Check name unique.
    // TODO resolve conflicting priorities.
    // Create a Lang
    const Lang = {code: code, name: name, priority: priority, active: active};
    // Save Lang in the database
    Lang.create(Lang)
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error creating language: " + err);
        res.status(500).send("Error creating language.");
    });
};

/**
 * Retrieve all languages from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    Lang.findAll({
        where: {active: true},
        attributes: {exclude: ['priority', 'active']},
        order: [['priority', 'ASC']]
    })
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error retrieving language: " + err);
        res.status(500).send("Error retrieving languages.");
    });
};

/**
 * Find a single language by it's code.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const code = req.params.code;
    Lang.findByPk(code)
    .then(data => {
        if (data) res.send(data);
        else res.status(404).send(`No language with code ${code}.`
            
        );
    })
    .catch(err => {
        logger.error("Error retrieving language with code " + code + ": " + err);
        res.status(500).send("Error retrieving language with code " + code + ".");
    });
};

/**
 * Update a single language by it's code.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.update = (req, res) => {
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const code = req.params.code;
    Lang.update(req.body, {where: {code: code}})
    .then(num => {
        if (num == 1) res.send("Language updated successfully.");
        else res.send(`Cannot update language with code ${id}.`);
    })
    .catch(err => {
        logger.error("Error updating language with code " + code + ": " + err);
        res.status(500).send("Error updating language with code " + code + ".");
    });
};

/**
 * Delete a single language by it's code.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.delete = (req, res) => {
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const code = req.params.code;
    Lang.destroy({where: {id: id}})
    .then(num => {
        if (num == 1) res.send("Language deleted successfully.");
        else res.send(`Cannot delete language with code ${id}.`);
    })
    .catch(err => {
        logger.error("Error deleting language with code " + code + ": " + err);
        res.status(500).send("Error deleting language with code " + code + ".");
    });
};

/**
 * Delete all languages.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    Lang.destroy({where: {}, truncate: false})
    .then(nums => {res.send({ message: `${nums} languages deleted successfully.`});})
    .catch(err => {
        logger.error("Error deleting languages: " + err);
        res.status(500).send("Error deleting languages.");
    });
};
