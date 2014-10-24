var express = require('express');
var path = require('path');
var logger = require('morgan');
var debug = require('debug')('appChat');


var app = express();


app.set('port', process.env.PORT || 3000);

var server = app.listen(app.get('port'), function() {
});

var io = require('socket.io').listen(server);

// uncomment after placing your favicon in /public
//app.use(favicon(__dirname + '/public/favicon.ico'));
app.use(logger('dev'));


app.all('/*', function(req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Credentials', true);
    res.header('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
    next();
});

//Liste des sokets utilisateurs
userList = {};

io.on('connection', function(socket){

    function updateNicknames(){
        io.sockets.emit('usernames', Object.keys(users));
    }

    socket.on('new user', function(data){
        // if user already connected
        socket.nickname = data;
        // Add socket to user array
        users[socket.nickname] = socket;
        updateNicknames();
    });

    socket.on('getUsernames', function(data){
        users[data].emit('usernames', Object.keys(users));
    });

    socket.on('send message', function(data, callback){
        var msg = data['msg'].trim().replace(/</g,"&lt;").replace(/>/g,"&gt;");
        console.log('after trimming message is: ' + msg);
        var to = data['to'];
        var fromUser = data['from'];
        if(to in users && fromUser in users){
            users[to].emit('new message', {msg: msg, from: fromUser, to:to});
            users[fromUser].emit('new message', {msg: msg, from: fromUser, to:to});
            console.log('message sent is: ' + msg);
            console.log('Whisper!');
        }
    });

    socket.on('disconnect', function(data){
        if(!socket.nickname) return;
        delete users[socket.nickname];
        updateNicknames();
    });

    socket.on('typing', function(data){
        var to = data['to'];
        var fromUser = data['from'];
        if(to in users && fromUser in users){
            users[to].emit('otherTyping', {isTyping: true, from: fromUser});
        }
    });


});


// catch 404 and forward to error handler
app.use(function(req, res, next) {
    var err = new Error('Not Found');
    err.status = 404;
    next(err);
});

// error handlers

// development error handler
// will print stacktrace
if (app.get('env') === 'development') {
    app.use(function(err, req, res, next) {
        res.status(err.status || 500);
        res.render('error', {
            message: err.message,
            error: err
        });
    });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
        message: err.message,
        error: {}
    });
});


module.exports = app;
