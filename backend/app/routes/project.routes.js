/**
 * @file Provides the routes for project access and management.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = app => {
    const projects = require("../controllers/project.controller.js");
    var router = require("express").Router();
    // Create a new project
    router.post("/", projects.create);
    // Retrieve all projects
    router.get("/", projects.findAll);
    // Retrieve top projects
    router.get("/top/:total", projects.findTop);
    // Retrieve a single project with id or permalink
    router.get("/:id", projects.findOne);
    // Update a project with id or permalink
    router.put("/:id", projects.update);
    // Delete a project with id or permalink
    router.delete("/:id", projects.delete);
    // Delete all projects
    router.delete("/", projects.deleteAll);
    app.use('/api/projects', router);
};
