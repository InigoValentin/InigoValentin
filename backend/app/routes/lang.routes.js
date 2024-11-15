/**
 * @file Provides the routes for language management.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = app => {
    const langs = require("../controllers/lang.controller.js");
    var router = require("express").Router();
    // Create a new language
    router.post("/", langs.create);
    // Retrieve all languages
    router.get("/", langs.findAll);
    // Retrieve a single language by its code
    router.get("/:code", langs.findOne);
    // Update a language by its code.
    router.put("/:code", langs.update);
    // Delete a language by its code.
    router.delete("/:code", langs.delete);
    // Delete all languages.
    router.delete("/", langs.deleteAll);
    app.use('/api/langs', router);
};
