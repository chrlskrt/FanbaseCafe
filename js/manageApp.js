$(function(){
    $("#createFanbaseForm").hide();
    $("#manageFanbasesTable").hide();
    $("#manageUsersTable").hide();

    $("#createFanbaseDiv").on("click", function(){
        // $("#createFanbaseForm").toggle();
        if ($("#createFanbaseForm").is(":visible")) {
            $("#fanbase_name").val("");
            $("#fanbase_artist").val("");
            $("#fanbase_description").val("");
            $("#createFanbaseForm").slideUp();
        } else {
            $("#createFanbaseForm").slideDown();
        }
    })

    $("#manageFanbasesDiv").on("click", function(){
        // $("#manageFanbasesTable").toggle();
        if ($("#manageFanbasesTable").is(":visible")) {
            $("#manageFanbasesTable").slideUp();
        } else {
            $("#manageFanbasesTable").slideDown();
        }
    })

    $("#manageUsersDiv").on("click", function(){
        // $("#manageUsersTable").toggle();
        if ($("#manageUsersTable").is(":visible")) {
            $("#manageUsersTable").slideUp();
        } else {
            $("#manageUsersTable").slideDown();
        }
    })
});