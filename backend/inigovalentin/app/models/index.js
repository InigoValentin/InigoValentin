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

db.users = require("./user.model.js")(sequelize, Sequelize);
db.langs = require("./lang.model.js")(sequelize, Sequelize);
db.texts = require("./text.model.js")(sequelize, Sequelize);
db.licenses = require("./license.model.js")(sequelize, Sequelize);
db.projects = require("./project.model.js")(sequelize, Sequelize);
db.projectTypes = require("./project-type.model.js")(sequelize, Sequelize);
db.projectUrlTypes = require("./project-url-type.model.js")(sequelize, Sequelize);
db.projectUrls = require("./project-url.model.js")(sequelize, Sequelize);
db.projectImages = require("./project-image.model.js")(sequelize, Sequelize);
db.tags = require("./tag.model.js")(sequelize, Sequelize);


db.projects.belongsTo(db.licenses, {foreignKey: 'licenseId', as: "license"});
db.licenses.hasMany(db.projects);

db.projects.belongsTo(db.projectTypes, {foreignKey: 'projectTypeId', as: "type"});
db.projectTypes.hasMany(db.projects);

const ProjectTag = sequelize.define("project-tag",{},{ timestamps: false });
db.projects.belongsToMany(db.tags, { through: ProjectTag });
db.tags.belongsToMany(db.projects, { through: ProjectTag });

db.projectUrls.belongsTo(db.projectUrlTypes, {foreignKey: 'projectUrlTypeId', as: "type"});
db.projectUrlTypes.hasMany(db.projectUrls);

db.projectUrls.belongsTo(db.projects, {foreignKey: 'projectId', as: "project"});
db.projects.hasMany(db.projectUrls);


db.projectImages.belongsTo(db.projects, {foreignKey: 'projectId', as: "project"});
db.projects.hasMany(db.projectImages);

module.exports = db;
