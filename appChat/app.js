var express = require('express');
var path = require('path');
var logger = require('morgan');
var debug = require('debug')('appChat');


var app = express();


app.set('port', process.env.PORT || 3000);

var server = app.listen(app.get('port'), function() {
    debug('Express server listening on port ' + server.address().port);
});

var io = require('socket.io').listen(server);

// uncomment after placing your favicon in /public
//app.use(favicon(__dirname + '/public/favicon.ico'));
app.use(logger('dev'));

/*app.all('*//*', function(req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Credentials', true);
    res.header('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
    next();
});*/

var users = [];

io.on('connection', function(socket){

    console.log('Socket connected !');

    //Liste des sokets utilisateurs

    function updateNicknames(){
        io.sockets.emit('usernames', getUserIds());
    }

    function getUsername(id) {
        return "User" + id;
    }

    function getUserIds() {
        keys = Object.keys(users);
        ids = [];
        for(i=0; i<keys.length; i++) {
            ids[i] = keys[i].substr(4);
        }
        console.log("Ids:", ids);
        return ids;
    }

    socket.on('new user', function(data){
        console.log('New user connected : ID : ' + data);

        // if user already connected
        socket.nickname = getUsername(data);
        // Add socket to user array
        users[socket.nickname] = socket;

        console.log('Liste des utilisateurs connectés : ');
        console.log(Object.keys(users));

        updateNicknames();
    });

    socket.on('getUsernames', function(data){
        users[getUsername(data)].emit('usernames', getUserIds());
    });

    socket.on('send message', function(data, callback){
        var msg = data['msg'].trim().replace(/</g,"&lt;").replace(/>/g,"&gt;");
        console.log('after trimming message is: ' + msg);
        var to = data['to'];
        var fromUser = data['from'];
        var conversation = data['conversation'];
        if(getUsername(to) in users && getUsername(fromUser) in users){
            users[getUsername(to)].emit('new message', {msg: msg, from: fromUser, to: to, conversation: conversation});
            users[getUsername(fromUser)].emit('new message', {msg: msg, from: fromUser, to: to, conversation: conversation});
            console.log('message sent to ' + to + ', from ' + fromUser + ' is: ' + msg);
        } else if (getUsername(fromUser) in users) {
            users[getUsername(fromUser)].emit('new message', {msg: msg, from: fromUser, to: to, conversation: conversation});
            console.log('message sent to ' + to + ' (user absent), from ' + fromUser + ' is: ' + msg);
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
            users[getUsername(to)].emit('otherTyping', {isTyping: true, from: fromUser});
        }
    });


});

app.all('*', function(req, res, next) {
    res.send(null);
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
