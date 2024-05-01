$(function(){
    // let hash = window.location.hash;
    // if (hash){
    //     post_id = hash.split("#post")[1];

    //     $(window).scrollTop($(hash).offset().top);
    //     viewPostModal(post_id);
    // }

    $("#createEventDiv").hide();
    $("#createPostDiv").hide();
    $(".replyDiv").hide();
    
    $("#btnCreateEvent").on("click", function(){
        $("#createEventDiv").toggle();
    })

    $("#btnCreatePost").on("click", function(){
        $("#createPostDiv").toggle();
    })

    if ($("#btnLeaveFanbase").length){
        $("#mainFanbaseContent").show();
    } else {
        $("#mainFanbaseContent").hide();
    }

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
            url: "includes/utilities/getIndivEvent.php",
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

    $(".btnReply").on("click", (e)=>{
        elem_id = $(e.target).attr("value");

        viewPostModal(elem_id); 
    })

    async function viewPostModal(postID){
        $.ajax({
            url: "includes/utilities/getIndivPost.php",
            method: "POST",
            data: {
                post_id: postID
            },
            dataType: 'JSON',
            success: function(data){
                // console.log(data);
                post = data;
                
                postzz = `#post${postID}`
                $("#postBody").html($(postzz).children(":first-child").html());
                $("#postReplies").html($(postzz).children(":last-child").html());
                $("#createReply_fanbaseID").val(post.fanbase_id);
                $("#createReply_postID").val(post.post_id);
                // $("#postCreateReply").html(postCreateReplyContent);
            }
        })

        $("#viewPostModal").modal("show");
    }

    $("#viewPostExitBtn").on("click", function(){
        $("#createReplyInput").val("");
    })
})