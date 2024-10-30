/**
 * @file Provides a service to handle languages and localizations.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const sha1 = require('sha1');
const jwt = require('jsonwebtoken');
const users = require("../controllers/user.controller.js");

const config = process.env;

/**
 * Handles localization of elements.
 */
class AuthService {
    
    /**
     * Database connection.
     */
    #db;
    
    /**
     * Constructor.
     *
     * @param db Database connection.
     * @constructor
     */
    constructor(db){
        this.#db = db;
    }
    
    /**
     * Logs a user in.
     * 
     * @param req The request received by the server.
     */
    async login(req, res){
        try {
            // Get user input
            const email = req.body.email ? req.body.email : "";
            const username = req.body.username ? req.body.username : "";
            const password = req.body.password;
            // Validate user input
            if (!(password && (email || username))) res.status(401).send("Credentials required");
            
            // Validate if user exist in our database
            const user = await User.findOne({where: {[this.#db.Sequelize.Op.or]: {username: username, email: email}}});
            if (user && user.password == sha1(user.hash + password)){
                require('dotenv').config()
                const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
                const token = jwt.sign({user: user.id}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '5h', issuer: TOKEN_ISSUER, subject: user.username})
                res.send({token});
            }
            return res.status(403).send("Invalid Credentials");
        }
        catch (err) {
            console.log("Error logging in: " + err);
            return res.status(500).send("Error logging in");
        }
    }
    
    /**
     * Validates a token in the request.
     * 
     * @param req The request received by the server.
     * @return An object with four values:
     *   - success: True if the user was authenticated, false otherwise.
     *   - user: The ID of the authenticated user, or null if no user was authenticated.
     *   - code: A HTTP status code that can be set on the response: 200, 401, 403 or 500.
     *   - message: A message describing the HTTP status code.
     */
    validateToken(req, res) {
        const token = req.body.token || req.query.token || req.headers["x-access-token"];
        console.log("TOKEN: " + token);
        if (!token) return {success: false, user: null, code: 401, message: "A token is required for authentication."};
        try {
            require('dotenv').config()
            const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
            const {exp, iss, user} = jwt.verify(token, TOKEN_SECRET);
            if (iss === TOKEN_ISSUER && exp < Date.now()) return {success: true, user: user, code: 200, message: "OK"};
            return {success: false, user: null, code: 403, message: "Invalid token."};;
        }
        catch (err) {
            console.log("Error validating token: " + err);
            return {success: false, user: null, code: 500, message: "Authentication error."};;
        }
    }
}
module.exports = AuthService;
