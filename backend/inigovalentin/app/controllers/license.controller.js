const db = require("../models");
const License = db.licenses;
const Op = db.Sequelize.Op;

const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService();

// Create and Save a new License
exports.create = (req, res) => {
    // Validate request
    if (!req.body.title) {
        res.status(400).send({
            message: "Content can not be empty!"
        });
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
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while creating the License."
        });
    });
};

// Retrieve all Licenses from the database.
exports.findAll = (req, res) => {
    //const title = req.query.title;
    
    //License.findAll({ where: condition })
    //License.findAll({include: ["titles"]})
    License.findAll({where: {visible: true,}})
    .then(async data => {
        data = await localeService.localizeLicenses(data, db);
        res.send(data);
    })
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while retrieving Licenses."});});
};

// Find a single License with an id
exports.findOne = (req, res) => {
    const id = req.params.id;
    License.findByPk(id)
    .then(async data => {
        if (data) {
            data = await localeService.localizeLicense(data, db);
            res.send(data);
        }
        else {
            res.status(404).send({message: `Cannot find License with id=${id}.`});
        }
    })
    .catch(err => {res.status(500).send({message: "Error retrieving License with id=" + id});});
};

// Update a License by the id in the request
exports.update = (req, res) => {
    const id = req.params.id;
    
    License.update(req.body, {
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "License was updated successfully."
            });
        } else {
            res.send({
                message: `Cannot update License with id=${id}. Maybe License was not found or req.body is empty!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Error updating License with id=" + id
        });
    });
};

// Delete a License with the specified id in the request
exports.delete = (req, res) => {
    const id = req.params.id;
    
    License.destroy({
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "License was deleted successfully!"
            });
        } else {
            res.send({
                message: `Cannot delete License with id=${id}. Maybe License was not found!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Could not delete License with id=" + id
        });
    });
};

// Delete all Licenses from the database.
exports.deleteAll = (req, res) => {
    License.destroy({
        where: {},
        truncate: false
    })
    .then(nums => {
        res.send({ message: `${nums} Licenses were deleted successfully!` });
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while removing all Licenses."
        });
    });
};

// Find all published Licenses
exports.findAllPublished = (req, res) => {
    License.findAll({ where: { published: true } })
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while retrieving Licenses."
        });
    });
};
