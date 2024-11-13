/**
 * @file Provides the routes for messages.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = app => {
    const messages = require("../controllers/message.controller.js");
    var router = require("express").Router();
    // Create a new message
    router.post("/", messages.create);
    app.use('/api/messages', router);
};
