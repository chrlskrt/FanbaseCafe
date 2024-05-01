$(function(){
    $("#createEventDiv").hide();
    $("#createPostDiv").hide();

    // $(".Replies").hide();
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

    // $(".btnReply").on("click", (e)=>{
    //     $elem = $(e.target).parent().parent().children(3);

    //     console.log($elem);
    //         $elem.show();
    //             // $(e.target > ".ReplyDiv").toggle();
    // })
    $('textarea').on("input", function(){
        this.style.height = 'auto';

        this.style.height = (this.scrollHeight) + 'px';
    })

    $('textarea').on("focus", function(){
        this.style.height = 'auto';

        this.style.height = (this.scrollHeight) + 'px';
    })

    $(".updateEventBtn").on("click", (e)=>{
        $elem_id = $(e.target).attr('id');
        $event_id = ($elem_id.split("-"))[1];

        $.ajax({
            url: "includes/utilities/getEvent.php",
            method: "POST",
            data: {
                event_id: $event_id
            },
            dataType: 'JSON',
            success: function(data){
                $event = data;
                
                $("#btnEditEventSubmit").val($event_id);
                $("#edit_event_name").val($event.event_name);
                $("#edit_event_type").val($event.event_type);
                $("#edit_event_date").val($event.event_date);
                $("#edit_event_time").val($event.event_time);
                $("#edit_event_location").val($event.event_location);
                $("#edit_event_description").val($event.event_description).height(this.scrollHeight + "px");
            }
        })

        $("#editEventModal").modal("show");
    });
})