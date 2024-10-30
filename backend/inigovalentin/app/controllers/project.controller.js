/**
 * @file Provides the model and operation for projects.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')()
const db = require("../models");
const Project = db.projects;
const Op = db.Sequelize.Op;
const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService(db);
const AuthService = require("../services/auth.service.js");
const authService = new AuthService(db);

/**
 * Create and save a new project.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const user = validation.user;
    
    // Validate request
    let missing = [];
    if (!req.body.permalink) missing.push("permalink");
    if (!req.body.title) missing.push("title");
    if (!req.body.header) missing.push("header");
    if (!req.body.type) missing.push("type");
    if (!req.body.license) missing.push("license");
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
    let permalink = req.body.permalink;
    // TODO: Validate and format permalink.
    let idx = 0; // TODO: Obtain it.
    const title = localeService.generateLocalizedObject(req.body.title, "PROJECT_" + permalink.toUpperCase().replace(" ", "").replace("-", "_"), "DB_PROJECT");
    if (title.valid === false){
        res.status(400).send("Invalid title values");
        return;
    }
    const header = localeService.generateLocalizedObject(req.body.header, "PROJECT_" + permalink.toUpperCase().replace(" ", "").replace("-", "_") + "_HEADER", "DB_PROJECT");
    if (header.valid === false){
        res.status(400).send("Invalid header values");
        return;
    }
    const text = localeService.generateLocalizedObject(req.body.text, "PROJECT_" + permalink.toUpperCase().replace(" ", "").replace("-", "_") + "_TEXT", "DB_PROJECT");
    const comment = localeService.generateLocalizedObject(req.body.comment, "PROJECT_" + permalink.toUpperCase().replace(" ", "").replace("-", "_") + "_COMMENT", "DB_PROJECT");
    const type = req.body.type; // TODO: Validate
    const logo = req.body.logo;
    const license = req.body.license; // TODO: Validate
    const visible = ((req.body.visible + "").toLowerCase() === 'true') ? true : false;
    localeService.saveLocalizedObject(title);
    localeService.saveLocalizedObject(header);
    localeService.saveLocalizedObject(text);
    localeService.saveLocalizedObject(comment);
    // Create a Project
    const Project = {
        permalink: permalink,
        user: user,
        idx: idx,
        projectTypeId: type,
        title: title,
        logo: logo,
        header: header,
        text: text,
        comment: comment,
        licenseId: license,
        visible: visible
    };
    
    // Save Project in the database
    Project.create(Project)
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error creating project: " + err);
        res.status(500).send({"Error creating project."});
    });
};

/**
 * Retrieve all projects from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    Project.findAll({
        where: {visible: true,}, 
        include: ["license", "type", "tags", {model: ProjectUrl, include: "type"}],
        attributes: { exclude: ['licenseId', 'projectTypeId'] },
        order: [['idx', 'ASC'], ['id', 'DESC']]
    })
    .then(async data => {
        data = await localeService.localizeProjects(data, req);
        res.send(data);
    })
    .catch(err => {
        logger.error("Error retrieving projects: " + err);
        res.status(500).send("Error retrieving projects.");
    });
};

/**
 * Find a single project by it's ID or permalink.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    Project.findOne({
        where: {visible: true, [Op.or]: {permalink: id, id: id }},
        include: ["license", "type", "tags", {model: ProjectUrl, include: "type"}, "project-images"],
        attributes: { exclude: ['licenseId', 'projectTypeId']}
    })
    .then(async data => {
        if (data){
            data = await localeService.localizeProject(data, req);
            res.send(data);
        }
        else res.status(404).send(`No project with id or permalink ${id}.`});
    })
    .catch(err => {
        logger.error("Error retrieving project with id or permalink " + id + ": " + err);
        res.status(500).send("Error retrieving project with id or permalink " + id + ".");
    });
};

/**
 * Update a single project by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.update = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const id = req.params.id;
    Project.update(req.body, {where: {[Op.or]: {permalink: id, id: id }}, user: user}})
    .then(num => {
        if (num == 1) res.send("Project updated successfully.");
        else res.send(`Cannot update project with id or permalink ${id}.`);
    })
    .catch(err => {
        logger.error("Error updating project with id or permalink " + id + ": " + err);
        res.status(500).send("Error updating project with id or permalink " + id + ".");
    });
};

/**
 * Delete a single project by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.delete = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const user = validation.user;
    const id = req.params.id;
    Project.destroy({where: {[Op.or]: {permalink: id, id: id }}, user: user}})
    .then(num => {
        if (num == 1) res.send({message: "Project deleted successfully."});
        else  res.send({message: `Cannot delete project with id or permalink ${id}.`});
    })
    .catch(err => {
        logger.error("Error deleting project with id or permalink " + id + ": " + err);
        res.status(500).send("Error deleting project with id or permalink " + id + ".");
    });
};

/**
 * Delete all projects.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const user = validation.user;
    Project.destroy({where: {user: user}, truncate: false})
    .then(nums => {res.send(`${nums} projects deleted successfully.`);})
    .catch(err => {
        logger.error("Error deleting projects: " + err);
        res.status(500).send("Error deleting projects.");
    });
};
