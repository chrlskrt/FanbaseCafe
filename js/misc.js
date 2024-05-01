export const viewModal = async (postID) => {
    $.ajax({
        url: "includes/utilities/getIndivPost.php",
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
            // $("#postCreateReply").html(postCreateReplyContent);
        }
    })

    $("#viewPostModal").modal("show");
};