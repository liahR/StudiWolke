const mysql = require('mysql');
const connection = mysql.createConnection({
  host: 'mars.iuk.hdm-stuttgart.de',
  user: 'lr090',
  password: 'eetho6Choh',
  database: 'u-lr090'
});

connection.connect((err) => {
  if (err) throw err;
  console.log('Datenbankverbindung aufgebaut');
});


