module.exports = (sequelize, Sequelize) => {
    const Lang = sequelize.define("lang", {
      code: {allowNull: false, primaryKey: true, type: Sequelize.STRING(8)},
      name: {type: Sequelize.STRING(64)},
      active: {type: Sequelize.BOOLEAN},
      default: {type: Sequelize.BOOLEAN},
    });
    return Lang;
}
