module.exports = (sequelize, Sequelize) => {
    const Lang = sequelize.define("lang", {
      code: {allowNull: false, primaryKey: true, type: Sequelize.STRING(8)},
      name: {type: Sequelize.STRING(64)},
      priority: {type: Sequelize.INTEGER},
      active: {type: Sequelize.BOOLEAN},
      default: {type: Sequelize.BOOLEAN},
    },
    {timestamps: false}
    );
    return Lang;
}
