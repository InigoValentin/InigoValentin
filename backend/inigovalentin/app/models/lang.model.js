/**
 * @file Provides the model for languages.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    const Lang = sequelize.define("lang", {
      code: {allowNull: false, primaryKey: true, type: Sequelize.STRING(8)},
      name: {allowNull: false, type: Sequelize.STRING(64)},
      priority: {allowNull: false, type: Sequelize.INTEGER},
      active: {allowNull: false, type: Sequelize.BOOLEAN}
    }, {timestamps: false});
    return Lang;
}
