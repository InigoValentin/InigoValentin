class LocaleService {
    
    constructor(){}
    
    getLanguage(db){
        // TODO: Implement;
        return "en"
    }
    
    async localizeProject(data, db){
        var result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.title], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.title = r.text;
            break;
        }
        result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.header], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.header = r.text;
            break;
        }
        result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.text], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.text = r.text;
            break;
        }
        result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.comment], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.comment = r.text;
            break;
        }
        return data;
    }
    
    async localizeProjects(data, db){
        for (var d of data)
            d = await this.localizeProject(d, db);
        return data;
    }
    
    async localizeLicense(data, db){
        var result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.summary], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.summary = r.text;
            break;
        }
        result = await db.sequelize.query('SELECT text FROM texts WHERE lang = ? AND id = ?', { replacements: ['en', data.dataValues.legal], type: db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            data.dataValues.legal = r.text;
            break;
        }
        return data;
    }
    
    async localizeLicenses(data, db){
        for (var d of data)
            d = await this.localizeLicense(d, db);
        return data;
    }

}
module.exports = LocaleService;
