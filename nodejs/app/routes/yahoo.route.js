const express = require("express");
const router = express.Router();
const yahoos = require("../controllers/yahoo.controller.js");

router.post('/get_info', yahoos.getInfo);
// router.get('/get_info', yahoos.getInfo);

module.exports = router;