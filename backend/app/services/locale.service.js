/**
 * @file Provides a service to handle languages and localizations.
 * @author Inigo Valentin
 * @since 4.0.0
 */

const logger = require('pino')();
const Lang = require("../models").langs;
const Text = require("../models").texts;

/**
 * Handles localization of elements.
 */
class LocaleService {

    /**
     * List of available languages.
     *
     * The one at index 0 is the default language.
     */
    #availableLanguages = Array();

    /**
     * Constructor.
     *
     * @constructor
     */
    constructor(){
        this.#init();
    }

    /**
     * Initializes the service.
     *
     * Called automatically from the constructor, retrieves available languages.
     */
    async #init(){
        const data = await Lang.findAll({where: {active: true}, order: [['priority', 'ASC']]})
        if (data) for (const r of data) this.#availableLanguages.push(r.code.toLowerCase().substring(0, 2));
        if (this.#availableLanguages.length == 0){
            logger.error("No languages retrieved from database, defaulting to 'en'.");
            this.#availableLanguages.push("en");
        }
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
        if (!req.query.lang && !req.body.lang) return this.#availableLanguages[0];
        let requestedLang = this.#availableLanguages[0];
        if (req.query.lang && req.body.lang && (req.query.lang != req.body.lang)){
            // Different languages in query and body, body has priority.
            requestedLang = req.body.lang.toLowerCase().substring(0, 2)
            if (this.#availableLanguages.indexOf(requestedLang) != -1) return requestedLang;
            else{
                requestedLang = req.query.lang.toLowerCase().substring(0, 2);
                if (this.#availableLanguages.indexOf(requestedLang) != -1) return requestedLang;
            }
        }
        else{
            if (req.body.lang) requestedLang = req.body.lang.toLowerCase().substring(0, 2)
            else if (req.query.lang) requestedLang = req.query.lang.toLowerCase().substring(0, 2)
            if (this.#availableLanguages.indexOf(requestedLang) != -1) return requestedLang;
            else return this.#availableLanguages[0];
        }
        return this.#availableLanguages[0];
    }

    /**
     * Decodes a text from the database.
     * 
     * @param result Result of a query to the table 'texts'. Must have at least the columns 'text' and 'file'.
     * @return The text.
     */
    async #decodeText(key, lang){
        
        const t = await Text.findOne({where: {id: key, lang: lang}});
        if (!t) return "";
        if (t.text) return "" + t.text;
        if (t.file) return "" + t.file; // TODO: Return file CONTENTS
        return "";
    }
    
    /**
     * Generates a localized object for text storing in database.
     * 
     * @param obj The object with the text in multiple languages. Language codes must be keys.
     * @param key The key to assign to the text.
     * @param section The section identifier for the text.
     * @return An object with those values:
     *   - valid: True if the object is valid and can be stored in database.
     *   - key: Identifier for the text.
     *   - section: Identifier fot the text section.
     *   - texts{}: An array for the text in different languages. Language codes are keys.
     */
    generateLocalizedObject(obj, key, section){
        let l = {valid: true, key: key, section: section, texts: {}};
        if (!key) l.valid = false;
        if (!section) l.valid = false;
        l.key = key;
        l.section = section;
        let body;
        try{
            body = JSON.parse(obj);
            for (let i = 0; i < this.#availableLanguages.length; i ++)
                if (body[this.#availableLanguages[i]] != undefined) l.texts[this.#availableLanguages[i]] = body[this.#availableLanguages[i]];
            if (Reflect.ownKeys(l.texts).length == 0) l.valid = false;
        }
        catch(err){
            l.valid = false;
        }
        return l;
    }

    /**
     * Saves a localized object in the database.
     * 
     * @param obj The object, as provided by {@see generateLocalizedObject}.
     * @return True on success, false on error.
     */
    async saveLocalizedObject(obj){
        if (!obj.valid || obj.valid != true || !obj.texts || obj.texts.length < 1) return false;
        for (const [lang, text] of Object.entries(obj.texts)){
            const t = {id: obj.key, lang: lang, section: obj.section, text: text, file: null};
            await Text.create(t)
            .catch(err => {logger.error("Error creating text with key " + id + " in lang " + lang + ": " + err);});
        }
        return true;
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
        if (data.dataValues.tags)
            for (var i = 0; i < data.dataValues.tags.length; i ++)
                data.dataValues.tags[i].tag = await this.#decodeText(data.dataValues.tags[i].tag, lang);
        if (data.dataValues["project-urls"])
            for (var i = 0; i < data.dataValues["project-urls"].length; i ++){
                data.dataValues["project-urls"][i].dataValues.type.dataValues.title = await this.#decodeText(data.dataValues["project-urls"][i].dataValues.type.dataValues.title, lang);
                data.dataValues["project-urls"][i].dataValues.type.dataValues.summary = await this.#decodeText(data.dataValues["project-urls"][i].dataValues.type.dataValues.summary, lang);
            }
        if (data.dataValues["project-images"])
            for (var i = 0; i < data.dataValues["project-images"].length; i ++)
                data.dataValues["project-images"][i].dataValues.alt = await this.#decodeText(data.dataValues["project-images"][i].dataValues.alt, lang);
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
    
    /**
     * Localizes a user.
     *
     * Localizes all localizable items in a user, using the language provided in the request or
     * the default one.
     *
     * @param data The user object to localize.
     * @param req The request received by the server.
     * @return The user object, with all of the fields localized.
     */
    async localizeUser(data, req){
        var lang = this.selectLanguage(req);
        if (data.dataValues.texts)
            for (var i = 0; i < data.dataValues.texts.length; i ++)
                data.dataValues.texts[i].text = await this.#decodeText(data.dataValues.texts[i].text, lang);
        if (data.dataValues.urls)
            for (var i = 0; i < data.dataValues.urls.length; i ++){
                data.dataValues.urls[i].name = await this.#decodeText(data.dataValues.urls[i].name, lang);
                data.dataValues.urls[i].description = await this.#decodeText(data.dataValues.urls[i].description, lang);
            }
        return data;
    }
    
    /**
     * Localize a list of users project types.
     *
     * Localize all localizable items in all users, using the language provided in the request or
     * the default one.
     *
     * @param data The user object list to localize.
     * @param req The request received by the server.
     * @return The user list, with all of their fields localized.
     */
    async localizeUserss(data, req){
        for (var d of data) d = await this.localizeUser(d, req);
        return data;
    }

}
module.exports = LocaleService;
