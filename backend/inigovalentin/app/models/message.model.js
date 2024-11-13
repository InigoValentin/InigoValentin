/**
 * @file Provides the model for projects.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    Message = sequelize.define("message", {
        id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
        userId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "users", key: "id"}},
        name: {allowNull: false, type: Sequelize.STRING(127)},
        email: {allowNull: false, type: Sequelize.STRING(127)},
        subject: {type: Sequelize.STRING(127)},
        text: {allowNull: false, type: Sequelize.STRING(5000)},
        lang: {type: Sequelize.STRING(8)},
        read: {allowNull: false, defaultValue: false, type: Sequelize.BOOLEAN},
    });
    return Message;
}
