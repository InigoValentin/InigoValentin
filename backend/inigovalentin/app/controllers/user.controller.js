/**
 * @file Provides the model and operation for users.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')();
const LocaleService = require('../services/locale.service.js');
const localeService = new LocaleService();
//const AuthService = require("../services/auth.service.js");
//const authService = new AuthService(db);

/**
 * Retrieve the active user info.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findActive = (req, res) => {
    User.findAll({
      where: {active: true},
      include: [
        {model: UserUrl, as: "urls", attributes: {exclude: ['id', 'userId', 'priority'], order: [['priority', 'ASC']]}},
        {model: UserText, as: "texts", attributes: {exclude: ['id', 'userId', 'section', 'global']}}
      ],
      attributes: {exclude: ['id', 'password', 'email', 'salt', 'active', 'admin', 'createdAt', 'updatedAt']},
    })
    .then(async data => {
        data = await localeService.localizeUser(data[0], req);
        res.send(data);
    })
    .catch(err => {
        logger.error("Error retrieving active user: " + err);
        res.status(500).send("Error retrieving active user.");
    });
};


/**
 * Retrieve all users from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    User.findAll()
    .then(async data => {
        data = await localeService.localizeUsers(data, req);
        res.send(data);
    })
    .catch(err => {
        logger.error("Error retrieving users: " + err);
        res.status(500).send("Error retrieving users.");
    });
};

/**
 * Find a single user by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    // Check authentication
    const validation = authService.validateToken(req, res);
    if (validation.success === false){
        res.status(validation.code).send(validation.message);
        return;
    }
    const id = req.params.id;
    User.findByPk(id)
    .then(async data => {
        if (data) {
            data = await localeService.localizeUser(data, req);
            res.send(data);
        }
        else res.status(404).send(`No user with id ${id}.`)
    })
    .catch(err => {
        logger.error("Error retrieving user with id " + id + ": " + err);
        res.status(500).send("Error retrieving user with id " + id + ".");
    });
};

/**
 * Update a single user by it's ID.
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
    User.update(req.body, {where: {id: id}})
    .then(num => {
        if (num == 1) res.send({message: "License was updated successfully."});
        else res.send(`Cannot update user with id=${id}.`);
    })
    .catch(err => {
        logger.error("Error updateing user: " + err);
        res.status(500).send("Error updating user.");
    });
};

/**
 * Delete a single user by it's ID. Currently disabled.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.delete = (req, res) => {return res.status(405).send("User deletion is disabled.");};

/**
 * Delete all users. Currently disabled.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.deleteAll = (req, res) => {return res.status(405).send("User deletion is disabled.");};

/**
 * Create and save a new user. Currently disabled.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = async (req, res) => {return res.status(405).send("User creation is disabled.");};
