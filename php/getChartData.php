<?php
    include('../connect.php');

    $chartData = array();

    $fanbaseMembers = array();
    $fanbaseEvents = array();
    $fanbasePosts = array();

    $sqlGetFanbaseMember = "SELECT fanbase_name, count(acc_fanbase_id) as member_count
                            FROM tbluseraccount_fanbase as m, tblfanbase as f 
                            WHERE m.fanbase_id = f.fanbase_id AND f.isDeleted = 0
                            GROUP BY m.fanbase_id";
    $getResult = mysqli_query($connection, $sqlGetFanbaseMember);

    while ($row = mysqli_fetch_assoc($getResult)){
        $fanbaseMembers[] = $row;
    }

    $chartData['fanbase_members'] = $fanbaseMembers;
    echo json_encode($chartData);
?>