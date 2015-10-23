var msgPath = $('#msgPath').data('id');
var getMsgPath = $('#getMsgPath').data('id');

var ita = $("#InputTextArea");
var chatBox = $('#ChatroomChatBox');
var username = $('#HeaderUsername').text();
var chatroomName = $('#ChatroomName').text();
var crDescription = $('#ChatroomWrapper');
var lastMessageTimeStamp = '';
/**
 *
 *
 *      START of DOM event listeners
 *
 *
 */

/* STARTUP ACTIONS */
$(document).ready(function () {
    scrollDownChatBox();
    /**TODO: check if the server has new messages,
     and only if so, refresh the page **/
    // refresh the ENTIRE conversation... OMG...
    setInterval(checkForNewMessagesFromServer, 700);
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
chatBox.change(function () {
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

/*
 * Handle user input in text box
 */
function handleUserInput() {
    var formatedMsg = formatUserInput(ita.val());
    if (formatedMsg.length == 0) return;
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
    }).fail(function () {
        checkOnServer();
    });

    // Must update chatroom...
}

/* Perform a simple filtration to the user input */
function formatUserInput(input) {
    return input.replace(/(\r\n|\n|\r)/gm, "");
}

/* Refresh chatroom conversations container */
function refreshConversations(response) {
    var resp = response['msg'];
    var r = resp.length;
    // if new messages are returned by the server,
    // refresh the conversations container
    if (r > 0) {
        for (i = 0; i < r; i++)
            chatBox.append(resp[i]);
        lastMessageTimeStamp = response['lastMsgTime'];
        scrollDownChatBox();
    }
}

/*
 * Asks the server for new messages
 */
function checkForNewMessagesFromServer() {
    var data = {
        'chatroom': chatroomName,
        'lastMessageReceived': lastMessageTimeStamp
    };
    $.ajax({
        url: getMsgPath,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json'
    }).done(function (response) {
        refreshConversations(response);
    }).fail(function () {
        checkOnServer();
    });
}

/*
 * Confirms if the server is still replying to requests
 */
function checkOnServer() {
    $.ajax({
        url: msgPath,
        type: 'POST',
        contentType: 'application/json',
        data: "",
        dataType: 'json'
    }).done(function () { // Server response - 200 OK
        return;
    }).fail(function () {
        alert("Sorry, but some problem has occured...\n\n\
                Please, send a bug report.");
        // refresh page
        location.reload();
    });
}





