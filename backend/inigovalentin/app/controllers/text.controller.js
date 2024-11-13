/**
 * @file Provides the model and operation for texts.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')();
const db = require("../models");
const Text = db.text;
const Op = db.Sequelize.Op;
const AuthService = require("../services/auth.service.js");
const authService = new AuthService(db);

/**
 * Create and save a new text.
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
    if (!req.body.id) missing.push("id");
    if (!req.body.lang) missing.push("lang");
    if (!req.body.section) missing.push("section");
    if (!req.body.text && !req.body.file) missing.push("text or file");
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
    // TODO: Validate
    // TODO: Accept only text or file

    // Create a Text
    const text = {id: id, lang: lang, section: section, text: text, file: file};
    
    // Save text in the database
    Text.create(text)
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error creating text: " + err);
        res.status(500).send("Error creating text.");
    });
};

/**
 * Retrieve all texts from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    // TODO: There is very little reason for this to exist
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    Text.findAll()
    .then(async data => {res.send(data);})
    .catch(err => {
        logger.error("Error retrieving texts: " + err);
        res.status(500).send("Error retrieving texts.");
    });
};

/**
 * Find a single project.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    const lang = req.params.lang;
    // TODO: Validate id and lang
    Text.findOne({where: {id: id, lang: lang}})
    .then(async data => {
        if (data) res.send(data);
        else res.status(404).send(`No text with id ${id} nd lang ${lang}.`);
    })
    .catch(err => {
        logger.error("Error retrieving text with id " + id + " in lang " + lang + ": " + err);
        res.status(500).send("Error retrieving text with id " + id + " in lang " + lang + ".");
    });
};

/**
 * Update a single text.
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
    const id = req.body.id;
    const lang = req.body.lang;
    Text.update(req.body, {where: {id: id, lang: lang}})
    .then(num => {
        if (num == 1) res.send("Text updated successfully.");
        else res.send(`Cannot update text with id ${id} nd lang ${lang}.`);
    })
    .catch(err => {
        logger.error("Error updating text with id " + id + " in lang " + lang + ": " + err);
        res.status(500).send("Error updating text with id " + id + " in lang " + lang + ".");
    });
};

/**
 * Delete a single text.
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
    const id = req.body.id;
    const lang = req.body.lang;
    Project.destroy({where: {id: id, lang: lang}})
    .then(num => {
        if (num == 1) res.send("Text deleted successfully.");
        else res.send(`Cannot delete text with id ${id} nd lang ${lang}.`);
    })
    .catch(err => {
        logger.error("Error deleting text with id " + id + " in lang " + lang + ": " + err);
        res.status(500).send("Error deleting text with id " + id + " in lang " + lang + ".");
    });
};

/**
 * Delete all texts.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {
    // TODO: There is very little reason for this to exist
    // Check authentication
    if (authService.validateToken(req, res).success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    Text.destroy({truncate: false})
    .then(nums => {res.send(`${nums} texts deleted successfully.`);})
    .catch(err => {
        logger.error("Error deleting texts: " + err);
        res.status(500).send("Error deleting texts.");
    });
};
