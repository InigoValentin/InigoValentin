module.exports = (sequelize, Sequelize) => {
    const Text = sequelize.define("text", {
      id: {allowNull: false, primaryKey: true, type: Sequelize.STRING(64)},
      lang: {allowNull: false, primaryKey: true, references: {model: "langs", key: "code"}, type: Sequelize.STRING(8)},
      section: {type: Sequelize.STRING(32)},
      text: {type: Sequelize.STRING(5000)},
      file: {type: Sequelize.STRING(32)},
    },
    { timestamps: false }
    );
    return Text;
}
