export const viewModal = async (postID) => {
    $.ajax({
        url: "php/getIndivPost.php",
        method: "POST",
        data: {
            post_id: postID
        },
        dataType: 'JSON',
        success: function(data){
            // console.log(data);
            let post = data;
            
            let postzz = `#post${postID}`
            $("#postBody").html($(postzz).children(":first-child").html());
            $("#postReplies").html($(postzz).children(":last-child").html());
            $("#createReply_fanbaseID").val(post.fanbase_id);
            $("#createReply_postID").val(post.post_id);
            $("#viewPostExitBtn").val(post.post_id + "-" + post.fanbase_id );
        }
    })

    $("#viewPostModal").modal("show");
};