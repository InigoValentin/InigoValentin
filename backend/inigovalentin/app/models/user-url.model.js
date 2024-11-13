/**
 * @file Provides the model for user urls.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    UserUrl = sequelize.define("user-url", {
        userId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "users", key: "id"}},
        priority: {allowNull: false, type: Sequelize.INTEGER},
        name: {allowNull: false, type: Sequelize.STRING(64)},
        description: {allowNull: false, type: Sequelize.STRING(64)},
        logo: {type: Sequelize.STRING(32)},
        url: {allowNull: false, type: Sequelize.STRING(256)}
    }, {timestamps: false});
    return UserUrl;
}
