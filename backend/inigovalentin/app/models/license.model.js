/**
 * @file Provides the model for licenses.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    const License = sequelize.define("license", {
      id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
      name: {allowNull: false, unique: true, type: Sequelize.STRING(32)},
      summary: {allowNull: false, type: Sequelize.STRING(64)},
      legal: {allowNull: false, type: Sequelize.STRING(64)},
      icon: {type: Sequelize.STRING(64)},
    }, {timestamps: false});
    return License;
}
