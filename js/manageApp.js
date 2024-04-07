$(function(){
    $("#createFanbaseForm").hide();
    $("#manageFanbasesTable").hide();
    $("#manageUsersTable").hide();

    $("#createFanbaseDiv").on("click", function(){
        $("#createFanbaseForm").toggle();
    })

    $("#manageFanbasesDiv").on("click", function(){
        $("#manageFanbasesTable").toggle();
    })

    $("#manageUsersTable").on("click", function(){
        $("#manageUsersTable").toggle();
    })
});