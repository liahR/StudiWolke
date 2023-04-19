const http = require('http')
const fs = require ('fs')
const path = require ('path')
const port = 3000

//server erstellen

const server = http.createServer(function(req, res) {
    if (req.url === '/') {
        const dateipfad = path.join(__dirname, '..', 'frontend', 'public', 'datenschutz.html');
        fs.readFile(dateipfad, function(error, data){
            if (error) {
                res.writeHead(404);
                res.end('Error: Datei nicht gefunden');
            } else {
                res.writeHead(200, { 'Content-Type': 'text/html'})
                res.end(data)
            }
        })    
    }})

server.listen(port, function(error) {
    if(error) {
        console.log('Fehler aufgetreten', error)
    } else {
        console.log('Server läuft auf Port' + port)
    }
})




