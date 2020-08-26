const express = require('express');
var cors = require('cors');
const app = express();
const bodyParser = require('body-parser');
const WebSocket = require('ws');


const clientSocket = {};


app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(cors());

app.get('/cekOnline', (req, res, next) => {
    if (req.query.username) {
        let online = Object.keys(clientSocket);
        if (online.indexOf(req.query.username) > -1) {
            res.send({
                status: 'online'
            })
        }
        else {
            res.send({
                status: 'offline'
            })
        }
    } else {
        res.status(404).send("bad request");
    }
})

const port = process.env.PORT || 4000

const server = app.listen(port, () => {
    console.log("app listen to port " + port);
})

const wss = new WebSocket.Server({ server });

wss.on('connection', function connection(ws, req) {

    let url = req.url;
    let arrayConnection = Object.keys(clientSocket)
    if (req.url.match(/username=/)) {
        let username = /\/?username=([^&]+)/.exec(req.url)[1];
        //console.log(arrayConnection);
        //if (arrayConnection.indexOf(username) === -1) {
        ws.on('message', (res) => {
            console.log(res);
            let parsed = JSON.parse(res);
            if (parsed.context === "kirimPesan") {
                let tujuan = parsed.to.username;
                let isipesan = parsed.to.isipesan;
                if (Object.keys(clientSocket).indexOf(parsed.to.username) === -1) {
                    console.log("tidak ada user");
                } else {
                    console.log("ada user");
                    clientSocket[tujuan].send(JSON.stringify({
                        context: "mendapatPesan",
                        data: {
                            from: username,
                            isipesan: isipesan
                        }
                    }))
                }
            }
        })

        ws.on('close', () => {
            delete clientSocket[username];
        })
        clientSocket[username] = ws;
        console.log(`client with username ${username} connected...`);
        //}
        //else {
        //    console.log("unauthorized");
        // }

    }
    else {
        console.log("bad query url");
    }
})

