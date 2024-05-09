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
        $("#createReplyInput").val("");
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
            url: "createReply.php",
            method: "POST",
            data: {
                post_id: postID,
                reply_text: replyText,
                fanbase_id: fanbaseID
            },
            success: function(data){
                console.log(data);
                reply = JSON.parse(data);

                replyDiv = `<div style="display: flex; flex-direction: column;">
                                <div style="display: flex; width: 100%; justify-content: space-between;">
                                    <div style="display:flex; gap:10px">
                                        <div style="display: flex; align-items: center">
                                            <img src="https://ui-avatars.com/api/?rounded=true&name=${reply.username}" alt="" style="height: 35; width:35">
                                        </div>
                                        <div style="display:flex; flex-direction:column; justify-content:center">
                                            <h5 style="margin-bottom:3px;">${reply.username}</h5>
                                            <p style="font-size: 10; color: gray; margin:0">${reply.reply_created}</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <form method="POST" action="deleteReply.php">
                                            <input type="hidden" name="fanbase_id" value="${reply.fanbase_id}">
                                            <input type="hidden" name="post_id" value="${reply.post_id}">
                                            <button type="submit" name="reply_id" value="${reply.reply_id}" class="btn btn-outline-light">🗑️</button>
                                        </form>
                                    </div>
                                </div>

                                <div style="margin-left: 45px">${reply.reply_text}</div>
                            </div>`;
                
                $("#postReplies").children(":first-child").append(replyDiv);
            },

            error: function(data){
                console.log("error", data);
            }
        })
    });
})