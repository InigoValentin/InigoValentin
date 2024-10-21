const db = require("../models");
const Lang = db.langs;
const Op = db.Sequelize.Op;

// Create and Save a new Lang
exports.create = (req, res) => {
    // Validate request
    if (!req.body.title) {
        res.status(400).send({
            message: "Content can not be empty!"
        });
        return;
    }
    
    // Create a Lang
    const Lang = {
        title: req.body.title,
        description: req.body.description,
        published: req.body.published ? req.body.published : false
    };
    
    // Save Lang in the database
    Lang.create(Lang)
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while creating the Lang."
        });
    });
};

// Retrieve all Langs from the database.
exports.findAll = (req, res) => {
    //const title = req.query.title;
    //var condition = title ? { title: { [Op.like]: `%${title}%` } } : null;
    
    //Lang.findAll({ where: condition })
    Lang.findAll()
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while retrieving Langs."
        });
    });
};

// Find a single Lang with an id
exports.findOne = (req, res) => {
    const id = req.params.id;
    
    Lang.findByPk(id)
    .then(data => {
        if (data) {
            res.send(data);
        } else {
            res.status(404).send({
                message: `Cannot find Lang with id=${id}.`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Error retrieving Lang with id=" + id
        });
    });
};

// Update a Lang by the id in the request
exports.update = (req, res) => {
    const id = req.params.id;
    
    Lang.update(req.body, {
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "Lang was updated successfully."
            });
        } else {
            res.send({
                message: `Cannot update Lang with id=${id}. Maybe Lang was not found or req.body is empty!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Error updating Lang with id=" + id
        });
    });
};

// Delete a Lang with the specified id in the request
exports.delete = (req, res) => {
    const id = req.params.id;
    
    Lang.destroy({
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "Lang was deleted successfully!"
            });
        } else {
            res.send({
                message: `Cannot delete Lang with id=${id}. Maybe Lang was not found!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Could not delete Lang with id=" + id
        });
    });
};

// Delete all Langs from the database.
exports.deleteAll = (req, res) => {
    Lang.destroy({
        where: {},
        truncate: false
    })
    .then(nums => {
        res.send({ message: `${nums} Langs were deleted successfully!` });
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while removing all Langs."
        });
    });
};

// Find all published Langs
exports.findAllPublished = (req, res) => {
    Lang.findAll({ where: { published: true } })
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while retrieving Langs."
        });
    });
};
