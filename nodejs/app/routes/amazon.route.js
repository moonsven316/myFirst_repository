const express = require("express");
const router = express.Router();
const amazon = require("../controllers/amazon.controller.js");

router.post('/getInfo', amazon.getInfo);

module.exports = router;