/**
 * @file Provides configuration for the database connection.
 * @author Inigo Valentin
 * @since 4.0.0
 */

require('dotenv').config()
const {DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME, DB_TYPE} = process.env;
module.exports = {
    HOST: DB_HOST,
    PORT: DB_PORT,
    USER: DB_USER,
    PASSWORD: DB_PASS,
    DB: DB_NAME,
    dialect: DB_TYPE,
    pool: {max: 5, min: 0, acquire: 30000, idle: 10000}
};
