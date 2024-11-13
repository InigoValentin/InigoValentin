/**
 * @file Provides the routes for user access.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const db = require("../models");
const AuthService = require('../services/auth.service.js');

module.exports = app => {
    const users = require("../controllers/user.controller.js");
    var router = require("express").Router();
    router.post("/register", users.create);
    router.post("/login", function(req, res) {
        const authService = new AuthService(db);
        authService.login(req, res);
    });
    app.use('/', router);

}
