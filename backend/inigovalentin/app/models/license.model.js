module.exports = (sequelize, Sequelize) => {
    const License = sequelize.define("license", {
      id: {allowNull: false, primaryKey: true, type: Sequelize.STRING(32)},
      summary: {allowNull: false, type: Sequelize.STRING(64)},
      legal: {allowNull: false, type: Sequelize.STRING(64)},
      logo: {type: Sequelize.STRING(64)},
      icon: {type: Sequelize.STRING(64)},
    },
    { timestamps: false }
    );
    return License;
}
