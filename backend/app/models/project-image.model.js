/**
 * @file Provides the model for project images.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
  const ProjectImage = sequelize.define("project-image", {
    id: {allowNull: false, primaryKey: true, type: Sequelize.STRING(32)},
    projectId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "projects", key: "id"}},
    idx: {type: Sequelize.SMALLINT}, // TODO REFERENCE
    image: {type: Sequelize.STRING(128)},
    alt: {type: Sequelize.STRING(64)},
  }, {timestamps: false});
  return ProjectImage;
}
