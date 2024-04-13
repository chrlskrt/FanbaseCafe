$(function(){
    $("#createEventDiv").hide();
    // $("#btnCreateEventSubmit").attr("disabled", "disabled");
    
    $("#btnCreateEvent").on("click", function(){
        $("#createEventDiv").toggle();
    })

    // $("#event_time").on("blur", function(){
    //     $input_time = $("#event_time").val();
        
    // })

    if ($("#btnLeaveFanbase").length){
        $("#mainFanbaseContent").show();
    } else {
        $("#mainFanbaseContent").hide();
    }
})