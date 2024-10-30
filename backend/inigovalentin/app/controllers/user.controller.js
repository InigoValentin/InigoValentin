/**
 * @file Provides the model and operation for users.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const sha1 = require('sha1');
const jwt = require('jsonwebtoken');
const db = require("../models");
const User = db.users;
const Op = db.Sequelize.Op;

/**
 * Retrieve all users from the database.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findAll = (req, res) => {
    User.findAll()
    .then(async data => {
        data = await localeService.localizeUsers(data, req);
        res.send(data);
    })
    .catch(err => {res.status(500).send({message: err.message || "Some error occurred while retrieving users."});});
};

/**
 * Find a single user by it's ID.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findOne = (req, res) => {
    const id = req.params.id;
    User.findByPk(id)
    .then(async data => {
        if (data) {
            data = await localeService.localizeUser(data, req);
            res.send(data);
        }
        else res.status(404).send({message: `Cannot find user with id=${id}.`})
    })
    .catch(err => {res.status(500).send({message: "Error retrieving user with id=" + id});});
};

/**
 * Find a single user by it's username or email.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.findByUsernameOrEmail = (req, res) => {
    const username = req.method === 'POST' ? req.body.username : req.params.username;
    const email = req.method === 'POST' ? req.body.email : req.params.email;
    if (!email && !username) res.status(400).send("Username or email required");
    User.findOne({where: {[Op.or]: {username: username, email: email}}})
    .then(async data => {
        if (data) {
            data = await localeService.localizeUser(data, req);
            res.send(data);
        }
        else res.status(404).send({message: `Cannot find user with username ${username} or email ${email}.`})
    })
    .catch(err => {res.status(500).send({message: "Error retrieving user."});});
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
    
    /**
     * Create and save a new user.
     * 
     * @param req The received request by the server.
     * @param res The request to be sent by the server.
     */
    exports.create = async (req, res) => {
        return res.status(405).send("User creation is disabled.");
        try {
            // Get user input
            const {username, firstName, lastName, email, password} = req.body;
            
            // Validate user input
            if (!(email && password && username)) {res.status(400).send("Credentials required.");}
            
            // check if user already exist
            // Validate if user exist in our database
            let existing = await User.findByUsernameOrEmail({username}, {email});
            if (existing) {return res.status(409).send("User already exists. Please login.");}
            existing = await User.findByEmail({email});
            if (existing) {return res.status(409).send("User already exists. Please login.");}
            
            //Encrypt user password
            encryptedUserPassword = await bcrypt.hash(password, 10);
            
            // Create user in our database
            const user = await User.create({
                first_name: firstName,
                last_name: lastName,
                email: email.toLowerCase(),
                password: encryptedUserPassword,
            });
            
            // Create token
            const token = jwt.sign({user_id: user.id}, 'process.env.TOKEN_KEY', {expiresIn: "5h"});
            // save user token
            user.token = token;
            User.update({token: token}, {where: {id: user.id }})
            return res.status(200).json({token: token});
        }
        catch (err) {
            console.log("Error registering user:" + err);
        }
    };
    
    /**
     * Log a user in.
     * 
     * @param req The received request by the server.
     * @param res The request to be sent by the server.
     */
    exports.login = async (req, res) => {
        try {
            // Get user input
            const email = req.body.email ? req.body.email : "";
            const username = req.body.username ? req.body.username : "";
            const password = req.body.password;
            // Validate user input
            if (!(password && (email || username))) res.status(400).send("Credentials required");
            
            // Validate if user exist in our database
            const user = await User.findOne({where: {[Op.or]: {username: username, email: email}}});
            //encryptedUserPassword = await bcrypt.hash(password, salt);
            //dbUserPassword = await bcrypt.hash(user.password, salt);
            //if (user && (await bcrypt.compare(password, user.password))) {
            //if (user && (await bcrypt.hash(user.password, salt) == await bcrypt.hash(password, salt))) {
            if (user && user.password == sha1(user.hash + password)){
                // Create token
                const token = jwt.sign({user_id: user.id}, 'process.env.TOKEN_KEY', {expiresIn: "5h"});
                // Save user token
                user.token = token;
                User.update({token: token}, {where: {id: user.id }})
                return res.status(200).json({token: token});
            }
            return res.status(400).send("Invalid Credentials");
        }
        catch (err) {
            console.log("Error logging in: " + err);
        }
    };
