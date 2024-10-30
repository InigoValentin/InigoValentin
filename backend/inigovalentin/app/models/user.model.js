/**
 * @file Provides the user model.
 * @author Inigo Valentin
 * @since 4.0.0
 */

module.exports = (sequelize, Sequelize) => {
    User = sequelize.define("user", {
        id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
        username: {allowNull: false, unique: true, type: Sequelize.STRING(32)},
        displayname: {allowNull: false, unique: true, type: Sequelize.STRING(32)},
        tagline: {allowNull: false, unique: true, type: Sequelize.STRING(64)},
        email: {allowNull: false, unique: true, type: Sequelize.STRING(128)},
        firstName: {type: Sequelize.STRING(128)},
        lastName: {type: Sequelize.STRING(128)},
        image: {type: Sequelize.STRING(64)},
        password: {allowNull: false, type: Sequelize.STRING(256)},
        salt: {allowNull: false, type: Sequelize.STRING(64)},
        active: {allowNull: false, default: true, type: Sequelize.BOOLEAN},
        admin: {allowNull: false, default: false, type: Sequelize.BOOLEAN},
    });
    return User;
}
