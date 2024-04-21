$(function(){
    $("#createEventDiv").hide();
    $("#createPostDiv").hide();

    $(".Replies").hide();
    // $("#btnCreateEventSubmit").attr("disabled", "disabled");
    
    $("#btnCreateEvent").on("click", function(){
        $("#createEventDiv").toggle();
    })

    $("#btnCreatePost").on("click", function(){
        $("#createPostDiv").toggle();
    })

    // $("#event_time").on("blur", function(){
    //     $input_time = $("#event_time").val();
        
    // })

    if ($("#btnLeaveFanbase").length){
        $("#mainFanbaseContent").show();
    } else {
        $("#mainFanbaseContent").hide();
    }

    $(".btnReply").on("click", (e)=>{
        $elem = $(e.target).parent().parent().children(3);

        console.log($elem);
            $elem.show();
                // $(e.target > ".ReplyDiv").toggle();
    })
})