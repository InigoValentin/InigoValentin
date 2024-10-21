
module.exports = (sequelize, Sequelize) => {
    Project = sequelize.define("project", {
      id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
      permalink: {type: Sequelize.STRING(64)},
      user: {type: Sequelize.INTEGER}, // TODO REFERENCE
      idx: {type: Sequelize.SMALLINT}, // TODO REFERENCE
      type: {type: Sequelize.STRING(8)},
      title: {allowNull: false, type: Sequelize.STRING(64), references: {model: "texts", key: "id"}},
      logo: {type: Sequelize.STRING(64)},
      header: {allowNull: false, type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
      text: {type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
      comment: {type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
      licenseId: {type: Sequelize.STRING(32), references: {model: "licenses", key: "id"}}, // TODO REFERENCE
      visible: {type: Sequelize.BOOLEAN},
    });
    return Project;
}
