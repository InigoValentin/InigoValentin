module.exports = (sequelize, Sequelize) => {
    ProjectType = sequelize.define("project-type", {
        id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
        title: {allowNull: false, type: Sequelize.STRING(64), references: {model: "texts", key: "id"}},
        summary: {type: Sequelize.STRING(512), references: {model: "texts", key: "id"}},
        icon: {type: Sequelize.STRING(64)},
    },
    {timestamps: false}
    );
    return ProjectType;
}
