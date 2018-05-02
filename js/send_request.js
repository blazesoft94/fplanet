$(document).ready(function(){
    $(".send-request").click(function(){
        var elem = this;
        var user_id = $(this).data("id");
        $.ajax({
            url: "./ajax/send_request.php?abc=hello&user_id="+user_id,
            method : "GET",
            success : function(data){
                if(data=="sent"){
                    var id = "#friend-suggestion-"+user_id;
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
});
