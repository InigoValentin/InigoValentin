const express = require("express");
const cors = require("cors");
const app = express();

var corsOptions = {origin: "*"};

app.use(cors(corsOptions));
//app.use(cors);
app.use(express.json());
app.use(express.urlencoded({extended: true}));

const db = require("./app/models")
db.sequelize.sync()
  .then(() => {console.log("Synced DB.");})
  .catch((err) => {console.log("Failed to sync DB: " + err.message);})
;

// Routes
app.get("/", (req, res) => {
    res.json({message: "Welcome to Inigo Valentin"});
});

require("./app/routes/lang.routes")(app);
require("./app/routes/text.routes")(app);
require("./app/routes/project.routes")(app);

const PORT = process.env.port || 8080;
app.listen(PORT, () => {console.log('Server running in port ${PORT}.')});


