var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var fs = require('fs');

app.listen(3334);

function handler (req, res) {
  fs.readFile(__dirname + '/index.html',
  function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }

    res.writeHead(200);
    res.end(data);
  });
}

io.on('connection', function (socket) {
  socket.on('FREEDOM', function (data) {
     // console.log(data);
      request = require('request');
      var download = function(uri, filename, callback){
        request.head(uri, function(err, res, body){
          // console.log('content-type:', res.headers['content-type']);
          // console.log('content-length:', res.headers['content-length']);
          request(uri).pipe(fs.createWriteStream(filename)).on('close', callback);
        });
      };
      download(data.my, 'file/'+data.name, function(){
         socket.emit('res', { Doneja: 'Done' });
      });
  });
});