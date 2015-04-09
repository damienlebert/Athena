var templateSelfMessage;
var templateOtherMessage;
var templateChatBox;
var avatars = new Array();


//console.log('dev: no-ajax-cache');
$.ajaxSetup({
    // Disable caching of AJAX responses
    cache: false
});

$.get('/bundles/athenachat/mustache/chat-self-message.hbs', function (template) {
    templateSelfMessage = template;
});
$.get('/bundles/athenachat/mustache/chat-other-message.hbs', function (template) {
    templateOtherMessage = template;
});
$.get('/bundles/athenachat/mustache/chat-box.hbs', function (template) {
    templateChatBox = template;
});

function ajouterConversation(login, nom)
{
    url = Routing.generate('get_conversation', { idOther: login.toString() });

    $.ajax({
        type: "GET",
        url: url,
        dataType:'json',
        success:function(retour) {

            var id_conversation = retour['id_conversation'];
            avatars[retour.user_conversation[0].user.id] = retour.user_conversation[0].user.avatar;
            avatars[retour.user_conversation[1].user.id] = retour.user_conversation[1].user.avatar;

            if($("#conversation-"+id_conversation).size() === 0){

                var viewData = {id_conversation: id_conversation, name: nom, loginOther: login};

                var rendered = Mustache.render(templateChatBox, viewData);
                $('#conversation-container').append(rendered);
                $.each(retour.messages, function(index, message) {
                    mine = true;
                    if(message.user_message == login) {
                        mine = false;
                    }
                    addMessage(id_conversation, message.contenu, message.date, mine, avatars[message.user_message]);
                });
                $('#messagesPanel-'+id_conversation).animate({scrollTop:60000}, 'fast');
                $('#messagesPanel-'+id_conversation).on('click', function(e){
                    $('#message-'+id_conversation).focus();
                });
                $('#message-'+id_conversation).focus();
            }
        },
        timeout: 7000
     });
}

function hide(id_conversation)
{
    if($('#conversation-'+id_conversation).attr("class")=="module hidden"){
         $('#conversation-'+id_conversation).attr("class","module visible");
         $('#bouton-conversation-'+id_conversation).attr("class","fixe-bas hidden");
        $('#message-'+id_conversation).focus();
    }else{
        $('#conversation-'+id_conversation).attr("class","module hidden");
        $('#bouton-conversation-'+id_conversation).attr("class","fixe-bas visible");
    }
}

function removeConversation(id_conversation)
{
    url = Routing.generate('remove_conversation', { idConversation: id_conversation.toString() });
    $('#bloc-conversation-'+id_conversation).remove();
    $.ajax({
        type: "GET",
        url: url,
        success:function(retour){
        }
    });
}

function addMessage(idConversation, content, date, bool, avatar) {
    var template = "";

    if (avatar == '' || avatar == 'undefined' || avatar == null) {
        avatar = 'avatar.png';
    }

    if (bool == '1') {
        template = templateSelfMessage;
    } else {
        template = templateOtherMessage;
    }

    if (date == '' || date == 'undefined' || date == null) {
        datestring = new Date();
        date = moment(new Date(), moment.ISO_8601, 'fr').fromNow();
    } else {
        datestring = date;
        date = moment(date, moment.ISO_8601, 'fr').fromNow();
    }

    viewData = { message: content, date: date, datestring: datestring, avatar:avatar };
    rendered = Mustache.render(template, viewData);

    $('ol#discussion-' + idConversation).append(rendered);
    $('#messagesPanel-'+ idConversation).animate({scrollTop:60000}, 'fast');
}

function setConnecte(login){
    $("#contact-"+login+" > span").attr("class", "glyphicon glyphicon-ok-circle droite connecte");
}
function setDeconnecte(login){
    $("#contact-"+login+" > span").attr("class", "glyphicon glyphicon-remove-circle droite non-connecte");
}

function updateConnected(usersConnectes)
{
    $("#liste-users > li").each(function(){
        var id = $(this).attr('id');
        var user = id.substr(8);
        if($.inArray(user, usersConnectes)>=0){
            setConnecte(user);
        }else{
            setDeconnecte(user);
        }
    });
}

function findUsers(search)
{
    console.log("Recherche de:" + search);
}
