/**
 * @file Provides the model and operation for project types.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const db = require("../models");
const ProjectType = db.project types;
const Op = db.Sequelize.Op;

const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService(db);

/**
 * Create and Save a new project type.
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
    
    // Create a ProjectType
    const ProjectType = {
        title: req.body.title,
        description: req.body.description,
        published: req.body.published ? req.body.published : false
    };
    
    // Save ProjectType in the database
    ProjectType.create(ProjectType)
    .then(data => {res.send(data);})
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while creating the ProjectType."});});
};

/**
 * Retrieve all project types from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    ProjectType.findAll()
    .then(async data => {
        data = await localeService.localizeProjectTypes(data, req);
        res.send(data);
    })
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while retrieving ProjectTypes."});});
};

/**
 * Find a single project type by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    ProjectType.findByPk(id)
    .then(async data => {
        if (data) {
            data = await localeService.localizeProjectType(data, req);
            res.send(data);
        }
        else res.status(404).send({message: `Cannot find ProjectType with id=${id}.`});}
})
    .catch(err => {res.status(500).send({message: "Error retrieving ProjectType with id=" + id});});
    };
    
    /**
     * Update a single project type by it's ID.
     * 
     * @param req The received request by the server.
     * @param res The request to be sent by the server.
     */
    exports.update = (req, res) => {
        const id = req.params.id;
        ProjectType.update(req.body, {where: {id: id}})
        .then(num => {
            if (num == 1) res.send({message: "ProjectType was updated successfully."});
            else res.send({message: `Cannot update ProjectType with id=${id}. Maybe ProjectType was not found or req.body is empty!`});
        })
        .catch(err => {res.status(500).send({message: "Error updating ProjectType with id=" + id});});
    };
    
    /**
     * Delete a single project type by it's ID.
     * 
     * @param req The received request by the server.
     * @param res The request to be sent by the server.
     */
    exports.delete = (req, res) => {
        const id = req.params.id;
        ProjectType.destroy({where: {id: id}})
        .then(num => {
            if (num == 1) res.send({message: "ProjectType was deleted successfully!"});
            else res.send({message: `Cannot delete ProjectType with id=${id}. Maybe ProjectType was not found!`});
        })
        .catch(err => {res.status(500).send({message: "Could not delete ProjectType with id=" + id});});
    };
    
    /**
     * Delete all project types.
     * 
     * @param req The received request by the server.
     * @param res The request to be sent by the server.
     */
    exports.deleteAll = (req, res) => {
        ProjectType.destroy({
            where: {},
            truncate: false
        })
        .then(nums => {res.send({ message: `${nums} ProjectTypes were deleted successfully!` });})
        .catch(err => {res.status(500).send({message: err.message || "Some error occurred while removing all ProjectTypes."});});
    };
    
