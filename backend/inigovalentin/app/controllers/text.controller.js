const db = require("../models");
const Text = db.texts;
const Op = db.Sequelize.Op;

// Create and Save a new Text
exports.create = (req, res) => {
    // Validate request
    if (!req.body.title) {
        res.status(400).send({
            message: "Content can not be empty!"
        });
        return;
    }
    
    // Create a Text
    const Text = {
        title: req.body.title,
        description: req.body.description,
        published: req.body.published ? req.body.published : false
    };
    
    // Save Text in the database
    Text.create(Text)
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while creating the Text."
        });
    });
};

// Retrieve all Texts from the database.
exports.findAll = (req, res) => {
    //const title = req.query.title;
    //var condition = title ? { title: { [Op.like]: `%${title}%` } } : null;
    
    //Text.findAll({ where: condition })
    Text.findAll()
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while retrieving Texts."
        });
    });
};

// Find a single Text with an id
exports.findOne = (req, res) => {
    const id = req.params.id;
    
    Text.findByPk(id)
    .then(data => {
        if (data) {
            res.send(data);
        } else {
            res.status(404).send({
                message: `Cannot find Text with id=${id}.`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Error retrieving Text with id=" + id
        });
    });
};

// Update a Text by the id in the request
exports.update = (req, res) => {
    const id = req.params.id;
    
    Text.update(req.body, {
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "Text was updated successfully."
            });
        } else {
            res.send({
                message: `Cannot update Text with id=${id}. Maybe Text was not found or req.body is empty!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Error updating Text with id=" + id
        });
    });
};

// Delete a Text with the specified id in the request
exports.delete = (req, res) => {
    const id = req.params.id;
    
    Text.destroy({
        where: { id: id }
    })
    .then(num => {
        if (num == 1) {
            res.send({
                message: "Text was deleted successfully!"
            });
        } else {
            res.send({
                message: `Cannot delete Text with id=${id}. Maybe Text was not found!`
            });
        }
    })
    .catch(err => {
        res.status(500).send({
            message: "Could not delete Text with id=" + id
        });
    });
};

// Delete all Texts from the database.
exports.deleteAll = (req, res) => {
    Text.destroy({
        where: {},
        truncate: false
    })
    .then(nums => {
        res.send({ message: `${nums} Texts were deleted successfully!` });
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while removing all Texts."
        });
    });
};

// Find all published Texts
exports.findAllPublished = (req, res) => {
    Text.findAll({ where: { published: true } })
    .then(data => {
        res.send(data);
    })
    .catch(err => {
        res.status(500).send({
            message:
            err.message || "Some error occurred while retrieving Texts."
        });
    });
};
