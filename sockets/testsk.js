// note, io(<port>) will create a http server for you
var io = require('socket.io')(3000);

io.on('connection', function (socket) {
console.log(socket.id);
    socket.on('sendtext', function(data) {
	console.log(data);
	socket.broadcast.emit('toall', data);
    })

    socket.on('user', function(data) {
	console.log(data);
    }) 

    socket.on('disconnect', function () {

    });
});

var removeByAttr = function(arr, attr, value){
    var i = arr.length;
    while(i--){
        if( arr[i]
            && arr[i].hasOwnProperty(attr)
            && (arguments.length > 2 && arr[i][attr] === value ) ){

            arr.splice(i,1);

        }
    }
    return arr;
}
