var user;
var otheruser;
var messages;

$(document).ready(function(){
    user = encodeURI(prompt("Who are you?"));
    otheruser = encodeURI(prompt("Who do you want to talk to?"));
    messages = document.getElementById('messages');
    wait();
});

function checkEnter(){
    if (event.keyCode === 13) {
    	send();
    }
}

function received(text){
	$('#messagetable').append("<tr><td class='received'>"+text+"</td></tr>");
	messages.scrollTop = messages.scrollHeight;
}

function sent(text){
	$('#messagetable').append("<tr><td class='sent'>"+text+"</td></tr>");
	messages.scrollTop = messages.scrollHeight;
    document.getElementById("newmessage").value="";
}

function wait(){
	$.ajax({
		type : "GET",
		url : "getMessage.php?from="+otheruser+"&to="+user,
		async : true,
		cache : false,
		timeout : 50000,
		success : function(data){
			received(data);
			setTimeout(wait, 500);
		},
		error : function(XMLHttpRequest, text, errorMessage){
			console.log(text+" - "+errorMessage);
			setTimeout(wait, 20000);
		}
	});
}

function send(){
	var msg = document.getElementById("newmessage").value;
    var url = "sendMessage.php?user="+user+"&to="+otheruser+"&msg="+encodeURI(msg);
    $.ajax({
        type: "GET",
        url: url,
        async: true,
        cache: false,
        success: function(data){
            sent(msg);
        }
    });
}