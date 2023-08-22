var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  // res.render('index', { title: 'Express' });
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
     header('Access-Control-Allow-Origin: *',
    'Content-Length': post_data.length
  }
  res.send("Freedom PageJa");
});

module.exports = router;
