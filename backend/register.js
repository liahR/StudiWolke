const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const app = express();

const connection = mysql.createConnection({
  host: 'mars.iuk.hdm-stuttgart.de',
  user: 'lr090',
  password: 'eetho6Choh',
  database: 'u-lr090'
});

// Verbindung zur Datenbank herstellen
db.connect((err) => {
    if (err) throw err;
    console.log('Datenbank verbunden');
});

// Registrierungsseite anzeigen
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'register.html'));
});

// Registrierungsdaten speichern
app.post('/register', (req, res) => {
    const { Vorname, Nachname, EMail, Nutzername, Passwort } = req.body;
    const Profilbild = req.files.Profilbild.name;
    const sql = `INSERT INTO users (Vorname, Nachname, EMail, Nutzername, Passwort, Profilbild) 
                 VALUES (?, ?, ?, ?, ?, ?)`;
    db.query(sql, [Vorname, Nachname, EMail, Nutzername, Passwort, Profilbild], (err, result) => {
        if (err) throw err;
        console.log(result);
        res.redirect('/success.html');
    });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server läuft auf Port ${PORT}`));