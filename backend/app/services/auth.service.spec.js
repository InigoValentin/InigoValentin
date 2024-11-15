/**
 * @file Tests for the authentication service.
 * @author Inigo Valentin
 * @since 4.0.0
 */

//require('../../node_modules/mysql2/node_modules/iconv-lite/lib').encodingExists('foo');

const httpMocks = require('node-mocks-http');
const jwt = require('jsonwebtoken');
const dotenv = require('dotenv');
dotenv.config({path: './env/test.env'});

const AuthService = require("./auth.service.js");
const authService = new AuthService();


test('Valid login - correct username, email and password', () => {
    const req = {body: {email: "email@example.com", username: "username", password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(200);});
});

test('Valid login - correct username and password, no email', () => {
    const req = {body: {username: "username", password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(200);});
});

test('Valid login - correct email and password, no username', () => {
    const req = {body: {email: "email@example.com", password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(200);});
});

test('Invalid login - no data', () => {
    const req = {body: {}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(401);});
});

test('Invalid login - correct username only', () => {
    const req = {body: {username: "username"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(401);});
});

test('Invalid login - correct email only', () => {
    const req = {body: {email: "email@example.com"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(401);});
});

test('Invalid login - corect password only', () => {
    const req = {body: {password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = null;
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(401);});
});

test('Invalid login - Correct username and email, wrong password', () => {
    const req = {body: {email: "email@example.com", username: "username", password: "BADpassword"}};
    const res = httpMocks.createResponse();
    const testUser = User.build({
        'email': 'email@example.com',
        'username': 'username',
        'password': '59b3e8d637cf97edbe2384cf59cb7453dfe30789',
        'salt': 'salt'
    });
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(403);});
});

test('Valid login - Correct username and password, wrong email', () => {
    const req = {body: {email: "BADemail@example.com", username: "username", password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = null;
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(403);});
});

test('Valid login - Correct mail and password, wrong username', () => {
    const req = {body: {email: "email@example.com", username: "BADusername", password: "password"}};
    const res = httpMocks.createResponse();
    const testUser = null;
    jest.spyOn(User, 'findOne').mockImplementation((options) => Promise.resolve(testUser));
    authService.login(req, res).then(data => {expect(data.statusCode).toBe(403);});
});

test('Valid token in body', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {token: token}, query: {}, headers: {}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(true);
    expect(validation.user).toBe(99);
    expect(validation.code).toBe(200);
    expect(validation.message).toBe("OK");
});

test('Valid token in request', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {}, query: {token: token}, headers: {}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(true);
    expect(validation.user).toBe(99);
    expect(validation.code).toBe(200);
    expect(validation.message).toBe("OK");
});

test('Valid token in headers', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {}, query: {}, headers: {"x-access-token": token}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(true);
    expect(validation.user).toBe(99);
    expect(validation.code).toBe(200);
    expect(validation.message).toBe("OK");
});

test('Invalid token in body', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {token: token + "BAD"}, query: {}, headers: {}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(false);
    expect(validation.user).toBe(null);
    expect(validation.code).toBe(403);
});

test('Invalid token in request', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {}, query: {token: token+ "BAD"}, headers: {}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(false);
    expect(validation.user).toBe(null);
    expect(validation.code).toBe(403);
});

test('Invalid token in headers', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {}, query: {}, headers: {"x-access-token": token + "BAD"}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(false);
    expect(validation.user).toBe(null);
    expect(validation.code).toBe(403);
});

test('No token', () => {
    const {TOKEN_SECRET, TOKEN_ISSUER} = process.env;
    const token = jwt.sign({user: 99}, TOKEN_SECRET, {algorithm: 'HS256', expiresIn: '10s', issuer: TOKEN_ISSUER, subject: "testuser"})
    const req = {body: {}, query: {}, headers: {}};
    const res = httpMocks.createResponse();
    const validation = authService.validateToken(req, res);
    expect(validation.success).toBe(false);
    expect(validation.user).toBe(null);
    expect(validation.code).toBe(401);
});
