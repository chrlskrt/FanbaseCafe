$(function(){
    $("#createEventDiv").hide();
    $("#createPostDiv").hide();
    $(".replyDiv").hide();

    $("#btnLeaveFanbase").on("click", function(){
        $("#leaveFanbaseModal").modal("show");
    })
    
    $("#btnCreateEvent").on("click", function(){
        $("#createEventModal").modal("show");
    })

    $("#btnCreatePost").on("click", function(){
        $("#createPostModal").modal("show");
    })

    $(".btnDeletePost").on("click", function(e){
        console.log("Delete");
        let post_id = $(e.target).val();
        $("#btnDeletePostConfirm").val(post_id);
        // $("#viewPostModal").css("z-index","1050")
        changeViewPostZIndex("1050");
        $("#deletePostModal").modal("show");
    })

    function changeViewPostZIndex(new_index){
        $("#viewPostModal").css("z-index", new_index);
    }

    $(".btnDeleteCancel").on("click", function(){
        changeViewPostZIndex("1070");
    })

    $(".btnDeleteEvent").on("click", function(e){
        let event_id = $(e.target).val();
        $("#btnDeleteEventConfirm").val(event_id);
        $("#deleteEventModal").modal("show");
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
            url: "php/getIndivEvent.php",
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
                $("#editEventModal").modal("show");
            }
        })
    });

    $("#updateEventDivReal").hide();
    $("#updateEventYes").on("click", ()=>{
        $("#updateEventDivReal").show();
        $(".updateEventDiv").hide();

        $("#event_name_confirm").html($("#edit_event_name").val());
        $("#event_type_confirm").html($("#edit_event_type").val());
        $("#event_date_confirm").html($("#edit_event_date").val());
        $("#event_time_confirm").html($("#edit_event_time").val());
        $("#event_location_confirm").html($("#edit_event_location").val());
        $("#event_description_confirm").html($("#edit_event_description").val());
    })

    $(".btnCancelEdit").on("click", ()=>{
        $("#editEventModal").modal("hide");
        $(".updateEventDiv").show();
        $("#updateEventDivReal").hide();
    })

    $("#btnCancelEventEdit").on("click", ()=>{
        $(".updateEventDiv").show();
        $("#updateEventDivReal").hide();
    })

    $(".btnReply").on("click", (e)=>{
        elem_id = $(e.target).attr("value");

        viewPostModal(elem_id); 
    })

    async function viewPostModal(postID){
        $("#createReplyInput").val("");
        $.ajax({
            url: "php/getIndivPost.php",
            method: "POST",
            data: {
                post_id: postID
            },
            dataType: 'JSON',
            success: function(data){
                // console.log(data);
                post = data;
                
                postzz = `#post${postID}`
                $("#postBody").append($(postzz).children(":first-child").children(":first-child").html());
                $("#modalDeletePost").val(post.post_id);
                $("#postReplies").html($(postzz).children(":last-child").html());
                $("#createReply_fanbaseID").val(post.fanbase_id);
                $("#createReply_postID").val(post.post_id);
                $("#viewPostExitBtn").val(post.post_id + "-" + post.fanbase_id );
                $("#viewPostModal").modal("show");

                $(".btnDeleteReply").click(function(event){
                    btnDeleteReplyClick(event);
                })
            }
        })
    }

    $("#viewPostExitBtn").on("click", function(){
        let val = $(this).val();
        val = val.split("-");
        let post = val[0];
        let fanbaseID = val[1];
        console.log(post);
        console.log(fanbaseID);
        $("#viewPostModal").modal("hide");
        window.location.replace("fanbase.php?fanbase_ID=" + fanbaseID).scrollTop($("#post"+post).offset().top);
    })

    $("#createReplyForm").on("submit", function(e){
        e.preventDefault();
        $("#createReplyInput").val("");
    })

    $("#createReply_postID").on("click", function(){
        replyText = $("#createReplyInput").val();
        console.log(replyText);

        if (replyText.length == 0){
            return;
        }

        postID = $("#createReply_postID").val();
        console.log(postID);

        fanbaseID = $("#createReply_fanbaseID").val();

        $.ajax({
            url: "php/createReply.php",
            method: "POST",
            data: {
                post_id: postID,
                reply_text: replyText,
                fanbase_id: fanbaseID
            },
            success: function(data){
                console.log(data);
                reply = JSON.parse(data);

                replyDiv = `<div class="d-flex">
                                <div style="display: flex; width: 100%; flex-direction:column">
                                    <div style="display:flex; gap:10px">
                                        <div style="display: flex; align-items: center">
                                            <img src="https://ui-avatars.com/api/?rounded=true&name=${reply.username}" alt="" style="height: 35; width:35">
                                        </div>
                                        <div style="display:flex; flex-direction:column; justify-content:center">
                                            <h5 style="margin-bottom:3px;">${reply.username}</h5>
                                            <p style="font-size: 10; color: gray; margin:0">${reply.reply_created}</p>
                                        </div>
                                    </div>
                                    <div style="margin-left: 45px">${reply.reply_text}</div>
                                </div><button type="submit" name="reply_id" value="${reply.reply_id}" class="btnDeleteReply btn btn-outline-light">🗑️</button>
                            </div>`;
                
                $("#postReplies").children(":first-child").append(replyDiv);

                $(".btnDeleteReply").click(function(){
                    btnDeleteReplyClick();
                })
            },

            error: function(data){
                console.log("error", data);
            }
        })
    });  

    function btnDeleteReplyClick (event){
        console.log("delete reply")
        changeViewPostZIndex("1050")
        $("#btnDeleteReplyConfirm").val(event.target.value);
        $("#deleteReplyModal").modal("show");
    }
});
