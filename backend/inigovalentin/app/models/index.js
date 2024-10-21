const dbConfig = require("../../config/db.config.js");

const Sequelize = require("sequelize");
const sequelize = new Sequelize(
  dbConfig.DB, dbConfig.USER, dbConfig.PASSWORD,
  {
    host: dbConfig.HOST, dialect: dbConfig.dialect, operationAliases: false, pool: {
      max: dbConfig.pool.max, min: dbConfig.pool.min,
      acquire: dbConfig.pool.acquire, idle: dbConfig.pool.idle
    }
  }
);

const db = {};
db.Sequelize = Sequelize;
db.sequelize = sequelize;
// 
db.langs = require("./lang.model.js")(sequelize, Sequelize);
db.texts = require("./text.model.js")(sequelize, Sequelize);
db.licenses = require("./license.model.js")(sequelize, Sequelize);
db.projects = require("./project.model.js")(sequelize, Sequelize);
//db.projects.hasMany(db.texts, {foreignkey: "title", as: "titles" });
//db.projects.hasOne(db.licenses, {foreignkey: "license", as: "licens" });
//db.licenses.belongsTo(db.projects, {foreignkey: "license"});

db.projects.belongsTo(db.licenses, {foreignKey: 'licenseId', as: "license"});
db.licenses.hasMany(db.projects);

module.exports = db;
