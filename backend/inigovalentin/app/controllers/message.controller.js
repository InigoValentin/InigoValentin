/**
 * @file Provides the model and operation for messages.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')();
const db = require("../models");
const User = db.users;
const Message = db.messages;
const Op = db.Sequelize.Op;

/**
 * Create and save a new message.
 * 
 * @param req The received request by the server.
 * @param res The request to be sent by the server.
 */
exports.create = async (req, res) => {
    // Validate request
    let missing = [];
    if (!req.body.name) missing.push("name");
    if (!req.body.email) missing.push("email");
    if (!req.body.text) missing.push("text");
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
    const name = req.body.name;
    const email = req.body.email;
    const subject = req.body.subject;
    const text = req.body.text;
    const lang = req.body.lang;
    //const user = User.findActive().id;
    const user = (await User.findOne({where: {active: true}})).id;
    console.log("ACTIVES: " + user);
    
    // Create a message
    const message = {
      userId: user, name: name, email: email, subject: subject, text: text, lang: lang
    };
    
    // Save Project in the database
    Message.create(message)
    .then(data => {res.send(data);})
    .catch(err => {
        logger.error("Error creating message: " + err);
        res.status(500).send("Error creating message.");
    });
};
