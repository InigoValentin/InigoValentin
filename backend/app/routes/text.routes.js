/**
 * @file Provides the routes for localized text access and management.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = app => {
    const texts = require("../controllers/text.controller.js");
    var router = require("express").Router();
    // Create a new text
    router.post("/", texts.create);
    // Retrieve all texts
    router.get("/", texts.findAll);
    // Retrieve a single text with id
    router.get("/:id", texts.findOne);
    // Update a text with id
    router.put("/:id", texts.update);
    // Delete a text with id
    router.delete("/:id", texts.delete);
    // Delete all texts
    router.delete("/", texts.deleteAll);
    app.use('/api/texts', router);
};
