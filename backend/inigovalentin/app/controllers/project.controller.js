/**
 * @file Provides the model and operation for projects.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const db = require("../models");
const Project = db.projects;
const Op = db.Sequelize.Op;

const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService(db);

/**
 * Create and Save a new project.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = (req, res) => {
    // Validate request
    if (!req.body.title) {
        res.status(400).send({ message: "Content can not be empty!" });
        return;
    }
    
    // Create a Project
    const Project = {
        title: req.body.title,
        description: req.body.description,
        published: req.body.published ? req.body.published : false
    };
    
    // Save Project in the database
    Project.create(Project)
    .then(data => {res.send(data);})
    .catch(err => { res.status(500).send({ message: err.message || "Some error occurred while creating the Project." }); });
};

/**
 * Retrieve all projects from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    Project.findAll({where: {visible: true,}, include: ["license", "type", "tags", {model: ProjectUrl, include: "type"}], attributes: { exclude: ['licenseId', 'projectTypeId'] }, order: [['idx', 'ASC'], ['id', 'DESC']] })
    .then(async data => {
        data = await localeService.localizeProjects(data, req);
        res.send(data);
    })
    .catch(err => { res.status(500).send({message: err.message || "Some error occurred while retrieving Projects."}); });
};

/**
 * Find a single License by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    Project.findOne({ where: { visible: true, [Op.or]: {permalink: id, id: id }}, include: ["license", "type", "tags", {model: ProjectUrl, include: "type"}, "project-images"], attributes: { exclude: ['licenseId', 'projectTypeId'] } })
    //Project.findByPk(id, { where: { visible: true }, include: ["license"], attributes: {exclude: ['licenseId'] } })
    .then(async data => {
        if (data) {
            data = await localeService.localizeProject(data, req);
            res.send(data);
        }
        else res.status(404).send({ message: `Cannot find Project with permalink or id=${id}.` });
    })
    .catch(err => { res.status(500).send({ message: "Error retrieving Project with permalink or id=" + id + ": " + err}); });
};
/**
 * Update a single project by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.update = (req, res) => {
    const id = req.params.id;
    
    Project.update(req.body, {
        where: { id: id }
    })
    .then(num => {
        if (num == 1) res.send({ message: "Project was updated successfully." });
        else res.send({ message: `Cannot update Project with id=${id}. Maybe Project was not found or req.body is empty!` });
    })
    .catch(err => { res.status(500).send({ message: "Error updating Project with id=" + id }); });
};

/**
 * Delete a single project by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.delete = (req, res) => {
    const id = req.params.id;
    
    Project.destroy({ where: { id: id } })
    .then(num => {
        if (num == 1) res.send({ message: "Project was deleted successfully!" });
        else  res.send({ message: `Cannot delete Project with id=${id}. Maybe Project was not found!` });
    })
    .catch(err => { res.status(500).send({ message: "Could not delete Project with id=" + id }); });
};

/**
 * Delete all projects.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {
    Project.destroy({
        where: {},
        truncate: false
    })
    .then(nums => { res.send({ message: `${nums} Projects were deleted successfully!` }); })
    .catch(err => { res.status(500).send({ message: err.message || "Some error occurred while removing all Projects." }); });
};
