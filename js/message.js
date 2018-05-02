$('.msg-head').click(function(){
    $("#msgs-list").html("");
   // Get the ID for the element that was clicked
   var friendId = $(this).attr('id');
   var userId = $(".header-content-wrapper").attr("id");
//    alert("popup_chat_ajax.php?user_id="+userId+"&friend_id="+friendId);
   $.ajax(
        {
            url: "popup_chat_ajax.php?user_id="+userId+"&friend_id="+friendId,
            success: function(data){
                $("#msgs-list").append(data);
                console.log("done");
            }
        }
    )
   
});
$(".send-message").on({
  "click":function(){
      sendMessage();
  }
});
$("#message-textbox").keypress(function(e){
if(e.which==13){
    sendMessage();
    // document.getElementById("message-textbox").textContent = "";
}});

function sendMessage(){
var data = $(document.getElementById("message-textbox")).val();
var user_id = $(".header-content-wrapper").attr("id");
var friend_id = $(document.getElementById("friend-id-input")).val();

var msgValues = {
    data,
    user_id,
    friend_id
}
$.ajax({
    url: "../send_message_ajax.php",
    data: msgValues,
    type: "post",
    success: function(data){
        if(data=="-1"){
            alert("Some error");
        }
        else{
            $("#message-textbox").val("");
            
            if($("#last-message").val()=="0"){
                $("#msgs-list li:last-of-type span:last").before("<span class='chat-message-item'> "+msgValues.data+"</span>");
            }
            else{
                $("#msgs-list").append('<li><div class="author-thumb"><img src="img/'+$("#user-image").val()+'-sm.jpg" alt="author" class="mCS_img_loaded"></div><div class="notification-event"><span class="chat-message-item">'+msgValues.data+'</span><span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Today at 8:29pm</time></span></div></li>');
            }
        }
    },
    error: function(d){
        alert("some error");
    }
})
}
