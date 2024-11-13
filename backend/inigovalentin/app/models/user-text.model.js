/**
 * @file Provides the model for user texts.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    UserText = sequelize.define("user-text", {
      userId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "users", key: "id"}},
      key: {allowNull: false, type: Sequelize.STRING(32)},
      section: {type: Sequelize.STRING(32)},
      global: {allowNull: false, false: true, type: Sequelize.BOOLEAN},
      text: {allowNull: false, unique: true, type: Sequelize.STRING(64)}
    }, {timestamps: false});
    return UserText;
}
