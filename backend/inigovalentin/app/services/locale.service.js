/**
 * @file Provides a service to handle languages and localizations.
 * @author Inigo Valentin
 * @since 4.0.0
 */

/**
 * Handles localization of elements.
 */
class LocaleService {

    /**
     * Database connection.
     */
    #db;

    /**
     * List of available languages.
     *
     * The one at index 0 is the default language.
     */
    #availableLanguages = Array();

    /**
     * Constructor.
     *
     * @param db Database connection.
     * @constructor
     */
    constructor(db){
        this.#db = db;
        this.#init();
    }

    /**
     * Initializes the service.
     *
     * Called automatically from the constructor.
     */
    async #init(){
        var result = await this.#db.sequelize.query('SELECT code FROM langs WHERE active = 1 ORDER by PRIORITY ASC ', { type: this.#db.sequelize.QueryTypes.SELECT })
        for (const r of result) this.#availableLanguages.push(r.code.toLowerCase().substring(0, 2));
    }

    /**
     * Selects the language to use.
     *
     * If the language is not in the request, using the GET parameter "lang", the default one set
     * in the database will be used.
     *
     * @param req The request received by the server.
     * @return Two letter language code to use.
     */
    selectLanguage(req){
        if (!req.query.lang) return this.#availableLanguages[0];
        var requestedLang = req.query.lang.toLowerCase().substring(0, 2)
        if (this.#availableLanguages.indexOf(requestedLang) != -1) return requestedLang;
        return this.#availableLanguages[0];
    }

    /**
     * Decodes a text from the database.
     * 
     * @param result Result of a query to the table 'texts'. Must have at least the columns 'text' and 'file'.
     * @return The text.
     */
    async #decodeText(key, lang){
        var result = await this.#db.sequelize.query('SELECT text, file FROM texts WHERE lang = ? AND id = ?', { replacements: [lang, key], type: this.#db.sequelize.QueryTypes.SELECT })
        for (const r of result) {
            if (r.text) return "" + r.text;
            if (r.file) return "" + r.file; // TODO: Return file CONTENTS
        }
        return "";
    }

    /**
     * Localizes a project.
     *
     * Localizes all localizable items in a project, using the language provided in the request or
     * the default one.
     *
     * @param data The project object to localize.
     * @param req The request received by the server.
     * @return The project object, with all of the fields localized.
     */
    async localizeProject(data, req){
        var lang = this.selectLanguage(req);
        data.dataValues.title = await this.#decodeText(data.dataValues.title, lang);
        data.dataValues.header = await this.#decodeText(data.dataValues.header, lang);
        data.dataValues.text = await this.#decodeText(data.dataValues.text, lang);
        data.dataValues.comment = await this.#decodeText(data.dataValues.comment, lang);
        if (data.dataValues.type){
            data.dataValues.type.title = await this.#decodeText(data.dataValues.type.title, lang);
            data.dataValues.type.summary = await this.#decodeText(data.dataValues.type.summary, lang);
        }
        if (data.dataValues.license){
            data.dataValues.license.summary = await this.#decodeText(data.dataValues.license.summary, lang);
            data.dataValues.license.legal = await this.#decodeText(data.dataValues.license.legal, lang);
        }
        for (var i = 0; i < data.dataValues.tags.length; i ++)
            data.dataValues.tags[i].tag = await this.#decodeText(data.dataValues.tags[i].tag, lang);
        for (var i = 0; i < data.dataValues["project-urls"].length; i ++){
            data.dataValues["project-urls"][i].dataValues.type.dataValues.title = await this.#decodeText(data.dataValues["project-urls"][i].dataValues.type.dataValues.title, lang);
            data.dataValues["project-urls"][i].dataValues.type.dataValues.summary = await this.#decodeText(data.dataValues["project-urls"][i].dataValues.type.dataValues.summary, lang);
        }
        for (var i = 0; i < data.dataValues["project-images"].length; i ++)
            data.dataValues["project-images"][i].dataValues.alt = await this.#decodeText(data.dataValues["project-images"][i].dataValues.alt, lang);
        //console.log(data.dataValues.projectUrls)
        return data;
    }

    /**
     * Localizes a list of projects.
     *
     * Localizes all localizable items in all projects, using the language provided in the request or
     * the default one.
     *
     * @param data The project object list to localize.
     * @param req The request received by the server.
     * @return The project list, with all of their fields localized.
     */
    async localizeProjects(data, req){
        for (var d of data) d = await this.localizeProject(d, req);
        return data;
    }

    /**
     * Localizes a license.
     *
     * Localizes all localizable items in a license, using the language provided in the request or
     * the default one.
     *
     * @param data The license object to localize.
     * @param req The request received by the server.
     * @return The license object, with all of the fields localized.
     */
    async localizeLicense(data, req){
        var lang = this.selectLanguage(req);
        data.dataValues.summary = await this.#decodeText(data.dataValues.summary, lang);
        data.dataValues.legal = await this.#decodeText(data.dataValues.legal, lang);
        return data;
    }

    /**
     * Localizes a list of projects licenses.
     *
     * Localizes all localizable items in all licenses, using the language provided in the request or
     * the default one.
     *
     * @param data The license object list to localize.
     * @param req The request received by the server.
     * @return The license list, with all of their fields localized.
     */
    async localizeLicenses(data, req){
        for (var d of data) d = await this.localizeLicense(d, req);
        return data;
    }

    /**
     * Localizes a project type.
     *
     * Localizes all localizable items in a project type, using the language provided in the request or
     * the default one.
     *
     * @param data The project type object to localize.
     * @param req The request received by the server.
     * @return The project type object, with all of the fields localized.
     */
    async localizeProjectType(data, req){
        var lang = this.selectLanguage(req);
        data.dataValues.title = await this.#decodeText(data.dataValues.title, lang);
        data.dataValues.summary = await this.#decodeText(data.dataValues.summary, lang);
        return data;
    }
    
    /**
     * Localizes a list of projects project types.
     *
     * Localizes all localizable items in all project types, using the language provided in the request or
     * the default one.
     *
     * @param data The project type object list to localize.
     * @param req The request received by the server.
     * @return The project type list, with all of their fields localized.
     */
    async localizeProjectTypes(data, req){
        for (var d of data) d = await this.localizeProjectType(d, req);
        return data;
    }

}
module.exports = LocaleService;
