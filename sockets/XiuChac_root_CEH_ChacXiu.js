// note, io(<port>) will create a http server for you
var io = require('socket.io')(3000);

var allThietbi = [];

io.on('connection', function (socket) {
    socket.on('tenthietbi', function(tenthietbi) {

        data = {
            'clientID': socket.id,
            'thietbi' : tenthietbi
        };

        var count = 0;
        allThietbi.forEach(function(value) {
            if(data == value.thietbi) {
                count = '1';
            }
        });

        if(count == 0) {
            allThietbi.push(data);
            console.log(data.thietbi + ' đăng nhập');
        }
    });

    socket.on('kt_thietbi', function(data) {
        allThietbi.forEach(function(value) {
            if(data == value.thietbi) {
                socket.emit('trung_tb', 'Thiết bị ' + data + ' đã được sử dụng');
            }
        })
    });

    socket.on('tally_send', function(data) {
        allThietbi.forEach(function(value) {
            if(data.EQU_Pre == value.thietbi) {
                socket.to(value.clientID).emit('tally_to_rtg', data);
            }

            if(data.cTractor == value.thietbi) {
                socket.to(value.clientID).emit('tally_to_truck', data);
            }
        });
    });

    socket.on('rtg_send', function(data) {
        allThietbi.forEach(function(value) {
            if(data.tractor == value.thietbi) {
                socket.to(value.clientID).emit('rtg_send_truck', data);
            }
        });

        socket.broadcast.emit('job_rtg', data);
    });

    socket.on('tally_xt_svr', function(data) {
        allThietbi.forEach(function(value) {
            if(data.EQU_Pre == value.thietbi) {
                socket.to(value.clientID).emit('srv_xt_rtg', data);
            }
        })
    })

    socket.on('rtg_xt_srv', function(data) {
        allThietbi.forEach(function(value) {
            if(data.ctractor == value.thietbi) {
                socket.to(value.clientID).emit('srv_xt_truck', data);
            }

            if(data.EQU == value.thietbi) {
                socket.to(value.clientID).emit('srv_xt_tally', data);
            }
        })
    })

    socket.on('tally_delete_truck_srv', function(data) {
        allThietbi.forEach(function(value) {
            if(data.cMaLoaiPT2 == value.thietbi) {
                socket.to(value.clientID).emit('srv_tally_delete_truck', data);
            }
        })
    });

    socket.on('logout', function(data) {
        removeByAttr(allThietbi, 'thietbi', data);
        console.log(data + ' đã thoát');
    });

    socket.on('disconnect', function () {
        var count = 0;
        allThietbi.forEach(function(value) {
            if(socket.id == value.clientID) {
                count = '1';
            }
        })

        if(count == '1') {
            console.log(socket.id + ' đã thoát');
            removeByAttr(allThietbi, 'clientID', socket.id);
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
