module.exports = app => {
    const projects = require("../controllers/lang.controller.js");
    
    var router = require("express").Router();
    
    // Create a new Lang
    router.post("/", projects.create);
    
    // Retrieve all Langs
    router.get("/", projects.findAll);
    
    // Retrieve all published Langs
    router.get("/published", projects.findAllPublished);
    
    // Retrieve a single Lang with id
    router.get("/:id", projects.findOne);
    
    // Update a Lang with id
    router.put("/:id", projects.update);
    
    // Delete a Lang with id
    router.delete("/:id", projects.delete);
    
    // Delete all Langs
    router.delete("/", projects.deleteAll);
    
    app.use('/api/langs', router);
};
