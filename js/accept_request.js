$(document).ready(function(){
    $(".done-request").click(function(){
        var friend_id = $(this).data("id");
        var request_id = $(this).data("requestid");
        var elem = this;
        // console.log(friend_id, request_id);
        $.ajax({
            url: "./ajax/accept_request.php?friend_id="+friend_id+"&request_id="+request_id,
            method : "GET",
            success : function(data){
                if(data=="success"){
                    var id = "#friend-request-"+friend_id;
                    // alert("request has been sent");
                    $(id).parent().parent().slideUp();
                }

                else{
                    // alert("some error");
                    console.log("some error");
                    console.log(data);
                }
            }
        });
    });
})