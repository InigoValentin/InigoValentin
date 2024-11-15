/**
 * @file Provides the model for projects.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
  Project = sequelize.define("project", {
    id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
    permalink: {allowNull: false, type: Sequelize.STRING(64)},
    user: {allowNull: false, type: Sequelize.INTEGER, references: {model: "users", key: "id"}},
    idx: {allowNull: false, type: Sequelize.SMALLINT},
    projectTypeId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "project-types", key: "id"}},
    title: {allowNull: false, type: Sequelize.STRING(64)},
    logo: {type: Sequelize.STRING(64)},
    header: {allowNull: false, type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
    text: {type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
    comment: {type: Sequelize.STRING(64)},//, references: {model: "texts", key: "id"}},
    licenseId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "licenses", key: "id"}},
    visible: {allowNull: false, type: Sequelize.BOOLEAN},
  });
  return Project;
}
