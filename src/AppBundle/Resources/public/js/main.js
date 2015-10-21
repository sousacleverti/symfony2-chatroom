var msgPath = $('#msgPath').data('id');
var getMsgPath = $('#getMsgPath').data('id');

var ita = $("#InputTextArea");
var chatBox = $('#ChatroomChatBox');
var username = $('#HeaderUsername').text();
var chatroomName = $('#ChatroomName').text();
var crDescription = $('#ChatroomWrapper');
var lastReceivedMessageTime = '';
/**
 *
 *
 *      START of DOM event listeners
 *
 *
 */

/* STARTUP ACTIONS */
$(document).ready(function(){
    scrollDownChatBox();
    /**TODO: check if the server has new messages,
             and only if so, refresh the page **/
    // refresh the ENTIRE conversation... OMG...
    setInterval(checkForNewMessagesFromServer, 2000);
});

/* Handle enter key pressed in textarea */
ita.keyup(function (e) {
    if (e.which === 13)
        handleUserInput();
    // prevent the event from propagating
    // and firing more than once
    e.preventDefault();
    e.stopImmediatePropagation();
});

/* Allways scroll the chatbox to the bottom */
chatBox.change(function() {
    scrollDownChatBox();
});

/* Handle send button click */
$('#SendButton').click(function (e) {
    // prevent the event from propagating
    // and firing more than once
    e.preventDefault();
    e.stopImmediatePropagation();
    handleUserInput();
    return false;
});

/* Open a popup window to properly read charoom description */
crDescription.click(function (e) {
    // prevent the event from propagating
    // and firing more than once
    e.preventDefault();
    e.stopImmediatePropagation();
    /* generate popup */
    var win = window.open("", chatroomName + " - Description",
            "toolbar=no, location=no,\n\
        directories=no, status=no, menubar=no, scrollbars=yes,\n\
        resizable=yes, width=550, height=350, top=" +
            parseInt((screen.height - 350) / 2, 10) + ",\n\
        left=" + parseInt((screen.width - 550) / 2, 10));
    win.document.body.innerHTML = crDescription.text();
});

/**
 *
 *
 *      END of DOM event listeners
 *
 *
 */

/* Scroll the chatbox to the bottom */
function scrollDownChatBox() {
    chatBox.scrollTop(chatBox.prop("scrollHeight"));
}

/* TODO*/
/* Server response callback missing... */
function handleUserInput() {
    var formatedMsg = formatUserInput(ita.val());
    if(formatedMsg.length == 0) return;
    // Remove user input text from textarea
    ita.val('');
    var data = {
        'chatroom': chatroomName,
        'user': username,
        'msg': formatedMsg
    };
    // POST user message to the server controller
    $.ajax({
        url: msgPath,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json'
    }).done(function () { // Server response - 200 OK
        refreshConversations();
    }).fail(function() {
        alert( "Sorry, but some problem has occured...\n\n\
        Please, send a bug report.");
        // redirect user to chatroom pool
        $(location).attr('href', '/chat');
    });

    // Must update chatroom...
}

/* Perform a simple filtration to the user input */
function formatUserInput(input) {
    return input.replace(/(\r\n|\n|\r)/gm, "");
}

/* TODO*/
function refreshConversations(messages) {
    for(i = 0; i < messages.length; i++) {
        chatBox.append(messages[i]);
        console.log(messages[i]);
    }
    scrollDownChatBox();
}

/*
 * Asks the server for new messages
 */
function checkForNewMessagesFromServer() {
    var data = {
        'chatroom': chatroomName,
        'lastMessageReceived': lastReceivedMessageTime
    };
    $.ajax({
        url: getMsgPath,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json'
    }).done(function (response) {
        // if new messages are returned by the server,
        // refresh the conversations container
        if(response['msg'].length > 0) {
            refreshConversations(response['msg']);
            lastReceivedMessageTime = response['lastMsgTime']
        }
    }).fail(function() {
        alert( "Sorry, but some problem has occured...\n\n\
                Please, send a bug report.");
//        // redirect user to chatroom pool
//        $(location).attr('href', '/chat');
    });
}