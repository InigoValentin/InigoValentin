module.exports = (sequelize, Sequelize) => {
    const Tag = sequelize.define("tag", {
        id: {allowNull: false, primaryKey: true, type: Sequelize.STRING(32)},
        tag: {allowNull: false, type: Sequelize.STRING(64)},
        icon: {type: Sequelize.STRING(64)},
    },
    {timestamps: false}
    );
    return Tag;
}
