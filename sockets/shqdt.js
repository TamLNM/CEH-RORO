// note, io(<port>) will create a http server for you
var io = require('socket.io')(3001);

var people = [];

io.on('connection', function (socket) {
    socket.on('nguoidung', function(nguoidung) {

        data = {
            'clientID': socket.id,
            'nguoidung' : nguoidung
        };

        var count = 0;
        people.forEach(function(value) {
            if(data == value.nguoidung) {
                count = '1';
            }
        });

        if(count == 0) {
            people.push(data);
            console.log(data.nguoidung + ' đăng nhập');
        }
    });

    socket.on('logout', function(data) {
        removeByAttr(people, 'nguoidung', data);
        console.log(data + ' đã thoát');
    });

    socket.on('disconnect', function () {
        var count = 0;
        people.forEach(function(value) {
            if(socket.id == value.clientID) {
                count = '1';
            }
        })

        if(count == '1') {
            console.log(socket.id + ' đã thoát');
            removeByAttr(people, 'clientID', socket.id);
        }
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
