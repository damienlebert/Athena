function ajouterConversation(login, nom)
{
        
        

        $.ajax({
            type: "GET",
            url: "managers/initMessages.php",
            dataType:'json',
            data: {userOther: login},            
            success:function(retour){
                var id_conversation = retour['id_conversation'];
                if($("#conversation-"+id_conversation).size() === 0){               
                    var messages = retour['messages'];                  
                    var conversation = '<div id="bloc-conversation-'+id_conversation+'" class="bloc-conversation visible"><div id="bouton-conversation-'+id_conversation+'" onClick="hide(\''+id_conversation+'\');return false;" class="fixe-bas hidden">\n\
                                            <div class="top-bar" style="bottom:15px;position:relative" >\n\
                                                <div class="left" >';
                    conversation += '               <span class="typcn typcn-message" id="logoBar-'+login+'"></span>';
                    conversation += '                   <h1>'+nom+'</h1>';
                    conversation += '           </div>';
                    conversation += '           <div class="right">'
                    conversation += '               <span class="glyphicon glyphicon-remove" onClick="removeConversation(\''+id_conversation+'\')"></span>';
                    conversation += '           </div>';
                    conversation += '       </div></div>';
                    conversation += '<div class="module visible" name="modal-conversation" id="conversation-'+id_conversation+'">\n\
                                            <div class="top-bar" onClick="hide(\''+id_conversation+'\');">\n\
                                                <div class="left" >';
                    conversation += '               <span class="typcn typcn-message" id="logoConv-'+login+'"></span>';
                    conversation += '                   <h1>'+nom+'</h1>';
                    conversation += '           </div>';
                    conversation += '           <div class="right">'
                    conversation += '               <span class="glyphicon glyphicon-remove" onClick="removeConversation(\''+id_conversation+'\')"></span>';
                    conversation += '           </div>';
                    conversation += '       </div>';
                    conversation += '       <div id="panel-message-'+login+'" class="visible">\n\
                                                <div class="discussionContainer" id="messagesPanel-'+login+'">';
                    conversation += '               <ol id="discussion-'+login+'" class="discussion">';

                    conversation += '               </ol>';
                    conversation += '           </div>';
                    conversation += '           <div class="form-group form-group-colle">';
                    conversation += '               <input type="text" class="form-control input-sm message-input" style="border-radius:0;" id="message-'+login+'" placeholder="Votre message">';
                    conversation += '           </div>\n\
                                            </div>';
                    conversation += '   </div></div>';
                    $("#conversation-container").append(conversation);   
                    
                    console.log(messages);
                    
                    for(index = 0; index < messages.length; index++){
                        var mess = messages[index];          

                        var bool = true;
                        if(mess['usr_msg'] == login){bool = false;}
                        addMessage(login, mess['contenu_msg'], mess['date_msg'], bool);
                    }
                }else{
                    if($('#conversation-'+id_conversation).attr("class")==="module hidden"){
                        $('#conversation-'+id_conversation).attr("class","module visible");
                        $('#bouton-conversation-'+id_conversation).attr("class","fixe-bas hidden");
                    }
                }
            }
         });
    
    
    
}

function hide(id_conversation)
{
    //$('#panel-message-'+login).toggle("medium");
    if($('#conversation-'+id_conversation).attr("class")=="module hidden"){
         $('#conversation-'+id_conversation).attr("class","module visible");
         $('#bouton-conversation-'+id_conversation).attr("class","fixe-bas hidden");
    }else{
        $('#conversation-'+id_conversation).attr("class","module hidden");
        $('#bouton-conversation-'+id_conversation).attr("class","fixe-bas visible");
    }
}

function removeConversation(id_conversation)
{
    $.ajax({
            type: "GET",
            url: "managers/disableConversation.php",
            data: {id_conversation: id_conversation}
        });
    $('#bloc-conversation-'+id_conversation).remove();
}

function addMessage(loginOther, content, date, bool)
{
  var message = "";
  message+=' <li class="';
  if(bool){
    message+='self';      
  }else{
    message+='other';      
  }
  message+='">';
  message+='       <div class="avatar">';
  message+='           <img src="/img/avatar.png" class="img-responsive"/>';
  message+='       </div>';
  message+='       <div class="messages">';
  message+='           <p>'+content+'</p>';
  message+='           <time>'+date+'</time>';
  message+='       </div>';
  message+='   </li>';
  
  $('#discussion-'+loginOther).append(message);
}

function setConnecte(login){
    $("#contact-"+login+" > span").attr("class", "glyphicon glyphicon-ok-circle droite connecte");
}
function setDeconnecte(login){
    $("#contact-"+login+" > span").attr("class", "glyphicon glyphicon-remove-circle droite non-connecte");
}

function updateConnected(usersConnectes)
{
    $("#users > tr").each(function(){
        var id = $(this).children('td').attr('id');
        var user = id.substr(8);
        if($.inArray(user, usersConnectes)>=0){
            setConnecte(user);
        }else{
            setDeconnecte(user);
        }
    });
}
