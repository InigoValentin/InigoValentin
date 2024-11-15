/**
 * @file Tests for the locale service.
 * @author Inigo Valentin
 * @since 4.0.0
 */

// This fixes some encoding errors with Jest
require('../../node_modules/mysql2/node_modules/iconv-lite/lib').encodingExists('foo');

const httpMocks = require('node-mocks-http');
const dotenv = require('dotenv');
dotenv.config({path: './env/test.env'});

const Lang = require("../models").langs;
const Text = require("../models").texts;
const LocaleService = require("./locale.service.js");



test('Select language - empty request, english exists', async () => {
    const req = {query: {}, body: {}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("en");
});

test('Select language - empty request, english doesn\'t exists', async () => {
    const req = {query: {}, body: {}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("eu");
});

test('Select language - empty request, no languages defined', async () => {
    const req = {query: {}, body: {}};
    var testLangs = []
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("en");
});

test('Select language - existing language in query', async () => {
    const req = {query: {lang: "es"}, body: {}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("es");
});

test('Select language - existing language in body', async () => {
    const req = {query: {}, body: {lang: "es"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("es");
});

test('Select language - non-existing language in query', async () => {
    const req = {query: {lang: "eu"}, body: {}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("en");
});

test('Select language - existing language in body', async () => {
    const req = {query: {}, body: {lang: "eu"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("en");
});

test('Select language - existing but conflicting languages in in query and body', async () => {
    const req = {query: {lang: "es"}, body: {lang: "eu"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("eu");
});

test('Select language - non existing and conflicting languages in in query and body', async () => {
    const req = {query: {lang: "ru"}, body: {lang: "ja"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("en");
});

test('Select language - existing language in query, non existing language in body', async () => {
    const req = {query: {lang: "es"}, body: {lang: "ru"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("es");
});

test('Select language - non-existing language in query, existing language in body', async () => {
    const req = {query: {lang: "ru"}, body: {lang: "es"}};
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const lang = localeService.selectLanguage(req);
    expect(lang).toBe("es");
});

test('Generate localized object - all available languages included', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "eu": "testeu"}', "key", "section");
    expect(obj.valid).toBe(true);
    expect(obj.key).toBe("key");
    expect(obj.section).toBe("section");
    expect(Reflect.ownKeys(obj.texts).length).toBe(3);
    expect(obj.texts.es).toBe("testes");
    expect(obj.texts.en).toBe("testen");
    expect(obj.texts.eu).toBe("testeu");
});

test('Generate localized object - some available languages included', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen"}', "key", "section");
    expect(obj.valid).toBe(true);
    expect(obj.key).toBe("key");
    expect(obj.section).toBe("section");
    expect(Reflect.ownKeys(obj.texts).length).toBe(2);
    expect(obj.texts.es).toBe("testes");
    expect(obj.texts.en).toBe("testen");
    expect(obj.texts.eu).toBe(undefined);
});

test('Generate localized object - available and unavailablelanguages included', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "ru": "testru"}', "key", "section");
    expect(obj.valid).toBe(true);
    expect(obj.key).toBe("key");
    expect(obj.section).toBe("section");
    expect(Reflect.ownKeys(obj.texts).length).toBe(2);
    expect(obj.texts.es).toBe("testes");
    expect(obj.texts.en).toBe("testen");
    expect(obj.texts.eu).toBe(undefined);
    expect(obj.texts.ru).toBe(undefined);
});

test('Generate localized object - no available languages included', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"ru": "testru", "ja": "testja"}', "key", "section");
    expect(obj.valid).toBe(false);
});

test('Generate localized object - available languages included, duplicated, both the same', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "es": "testes"}', "key", "section");
    expect(obj.valid).toBe(true);
    expect(obj.key).toBe("key");
    expect(obj.section).toBe("section");
    expect(Reflect.ownKeys(obj.texts).length).toBe(1);
    expect(obj.texts.es).toBe("testes");
    expect(obj.texts.en).toBe(undefined);
    expect(obj.texts.eu).toBe(undefined);
});

test('Generate localized object - available languages included, duplicated, both different', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes1", "es": "testes2"}', "key", "section");
    expect(obj.valid).toBe(true);
    expect(obj.key).toBe("key");
    expect(obj.section).toBe("section");
    expect(Reflect.ownKeys(obj.texts).length).toBe(1);
    expect(obj.texts.es).toBe("testes2");
    expect(obj.texts.en).toBe(undefined);
    expect(obj.texts.eu).toBe(undefined);
});

test('Generate localized object - valid object, no key', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "eu": "testeu"}', null, "section");
    expect(obj.valid).toBe(false);
});

test('Generate localized object - valid object, no section', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "eu": "testeu"}', "key", null);
    expect(obj.valid).toBe(false);
});

test('Generate localized object - bad object', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject("bad", "key", "section");
    expect(obj.valid).toBe(false);
});

test('Save localized object - valid object', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    jest.spyOn(Text, 'create').mockImplementation((options) => Promise.resolve(true));
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "eu": "testeu"}', "key", "section");
    expect(await localeService.saveLocalizedObject(obj)).toBe(true);
});

test('Save localized object - invalid object', async () => {
    var testLangs = []
    testLangs.push(Lang.build({'code': 'en', 'name': 'English', 'priority': 1, 'active': true}));
    testLangs.push(Lang.build({'code': 'es', 'name': 'Espanol', 'priority': 2, 'active': true}));
    testLangs.push(Lang.build({'code': 'eu', 'name': 'Euskara', 'priority': 3, 'active': true}));
    jest.spyOn(Lang, 'findAll').mockImplementation(() => testLangs);
    jest.spyOn(Text, 'create').mockImplementation((options) => Promise.resolve(true));
    const localeService = new LocaleService();
    await new Promise((r) => setTimeout(r, 30));
    const obj = localeService.generateLocalizedObject('{"es": "testes", "en": "testen", "eu": "testeu"}', "key", null);
    expect(await localeService.saveLocalizedObject(obj)).toBe(false);
});

// TODO: Implement test for localization functions once they are complete
