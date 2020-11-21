var app 	= require('express')(),
	http 	= require('http').Server(app),
	io 		= require('socket.io')(http);

app.get('/', function(req, res){
  	res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
	console.log('a user connected');
	socket.on('tally', function(msg){
	    io.emit('tally', msg);
	});
});	

http.listen(8081, function(){
  	console.log('listening on *:8081');
});

io.emit('some event', { for: 'everyone' });
