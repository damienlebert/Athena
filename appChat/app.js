var express = require('express');
var path = require('path');
var logger = require('morgan');
var debug = require('debug')('appChat');


var app = express();


app.set('port', process.env.PORT || 3000);

var server = app.listen(app.get('port'), function() {
    debug('Express server listening on port ' + server.address().port);
});

console.log("Server: " + server.address().port);

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
var userfullnames = [];

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

    function emoticonize(text) {

        text = text.replace(/:\)/g, "<span class='icon-smile2'></span>");
        text = text.replace(/=\)/g, "<span class='icon-smile2'></span>");

        text = text.replace(/:p/g, "<span class='icon-tongue2'></span>");
        text = text.replace(/=p/g, "<span class='icon-tongue2'></span>");
        text = text.replace(/:P/g, "<span class='icon-tongue2'></span>");
        text = text.replace(/=P/g, "<span class='icon-tongue2'></span>");

        text = text.replace(/:\(/g, "<span class='icon-sad2'></span>");
        text = text.replace(/=\(/g, "<span class='icon-sad2'></span>");

        text = text.replace(/;\)/g, "<span class='icon-wink2'></span>");

        text = text.replace(/:d/g, "<span class='icon-grin2'></span>");
        text = text.replace(/=d/g, "<span class='icon-grin2'></span>");
        text = text.replace(/:D/g, "<span class='icon-grin2'></span>");
        text = text.replace(/=D/g, "<span class='icon-grin2'></span>");

        text = text.replace(/:@/g, "<span class='icon-angry2'></span>");
        text = text.replace(/=@/g, "<span class='icon-angry2'></span>");

        text = text.replace(/:O/g, "<span class='icon-shocked2'></span>");
        text = text.replace(/=O/g, "<span class='icon-shocked2'></span>");
        text = text.replace(/:o/g, "<span class='icon-shocked2'></span>");
        text = text.replace(/=o/g, "<span class='icon-shocked2'></span>");

        text = text.replace(/:s/g, "<span class='icon-confused2'></span>");
        text = text.replace(/=s/g, "<span class='icon-confused2'></span>");
        text = text.replace(/:S/g, "<span class='icon-confused2'></span>");
        text = text.replace(/=S/g, "<span class='icon-confused2'></span>");

        text = text.replace(/:\|/g, "<span class='icon-neutral2'></span>");
        text = text.replace(/=\|/g, "<span class='icon-neutral2'></span>");

        text = text.replace(/:\//g, "<span class='icon-wondering2'></span>");
        text = text.replace(/=\//g, "<span class='icon-wondering2'></span>");

        text = text.replace(/:'\(/g, "<span class='icon-crying2'></span>");
        text = text.replace(/='\(/g, "<span class='icon-crying2'></span>");
        return text;
    }

    socket.on('new user', function(data){
        console.log('New user connected : ID : ' + data['id']);

        // if user already connected
        socket.nickname = getUsername(data['id']);
        // Add socket to user array
        users[socket.nickname] = socket;
        userfullnames[socket.nickname] = data['fullname'];

        console.log('Liste des utilisateurs connectés : ');
        console.log(Object.keys(users));

        io.sockets.emit('new user connected', {id: data['id'], fullname: data['fullname']});

        updateNicknames();
    });

    socket.on('getUsernames', function(data){
        users[getUsername(data)].emit('usernames', getUserIds());
    });

    socket.on('send message', function(data, callback){
        var msg = data['msg'].trim().replace(/</g,"&lt;").replace(/>/g,"&gt;");
        msg = emoticonize(msg);
        console.log('Before send / After trimming message is: ' + msg);
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

    socket.on('chatroom message', function(data, callback){

        var msg = data['msg'].trim().replace(/</g,"&lt;").replace(/>/g,"&gt;");
        msg = emoticonize(msg);
        var fromUser = data['from'];
        if (getUsername(fromUser) in users) {
            //userIds = Object.keys(users);
            //for (i=0; i<userIds.length; i++) {
            io.sockets.emit('new chatroom message', {msg: msg, from: fromUser, fullname: userfullnames[getUsername(fromUser)]});
            //}
            console.log("message sent to ALL, from " + fromUser + " is: " + msg);
        }

    });

    socket.on('disconnect', function(data){
        if(!socket.nickname) return;
        delete users[socket.nickname];
        updateNicknames();
        io.sockets.emit('user disconnected', {fullname: userfullnames[socket.nickname]});
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
