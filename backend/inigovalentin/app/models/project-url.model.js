module.exports = (sequelize, Sequelize) => {
    ProjectUrl = sequelize.define("project-url", {
        id: {allowNull: false, autoIncrement: true, primaryKey: true, type: Sequelize.INTEGER},
        projectId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "projects", key: "id"}},
        projectUrlTypeId: {allowNull: false, type: Sequelize.INTEGER, references: {model: "project-url-types", key: "id"}},
        url: {type: Sequelize.STRING(512)},
    },
    {timestamps: false}
    );
    return ProjectUrl;
}
