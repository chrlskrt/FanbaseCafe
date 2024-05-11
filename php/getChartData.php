<?php
    $fanbaseMembers = array();
    $fanbaseMembers['fanbase'] = array();
    $fanbaseMembers['member_count'] = array();

    $sqlGetFanbaseMember = "SELECT fanbase_name, count(acc_fanbase_id) as member_count
                            FROM tbluseraccount_fanbase as m, tblfanbase as f 
                            WHERE m.fanbase_id = f.fanbase_id AND f.isDeleted = 0
                            GROUP BY m.fanbase_id";
    $getResult = mysqli_query($connection, $sqlGetFanbaseMember);

    while ($row = mysqli_fetch_assoc($getResult)){
        $fanbaseMembers['fanbase'][] = $row['fanbase_name'];
        $fanbaseMembers['member_count'][] = $row['member_count'];
    }

    $fanbaseEvents = array();
    $fanbaseEvents['fanbase'] = array();
    $fanbaseEvents['event_count'] = array();

    $sqlGetFanbaseEvent = "SELECT fanbase_name, count(event_id) as event_count
                            FROM tblevent as e, tblfanbase as f 
                            WHERE e.fanbase_id = f.fanbase_id AND f.isDeleted = 0
                            GROUP BY e.fanbase_id";
    $getResult = mysqli_query($connection, $sqlGetFanbaseEvent);

    while ($row = mysqli_fetch_assoc($getResult)){
        $fanbaseEvents['fanbase'][] = $row['fanbase_name'];
        $fanbaseEvents['event_count'][] = $row['event_count'];
    }

    $fanbasePosts = array();
    $fanbasePosts['fanbase'] = array();
    $fanbasePosts['post_count'] = array();

    $sqlGetFanbasePost = "SELECT fanbase_name, count(post_id) as post_count
                            FROM tblPost as p, tblfanbase as f 
                            WHERE p.fanbase_id = f.fanbase_id AND f.isDeleted = 0
                            GROUP BY p.fanbase_id";
    $getResult = mysqli_query($connection, $sqlGetFanbasePost);
    while ($row = mysqli_fetch_assoc($getResult)){
        $fanbasePosts['fanbase'][] = $row['fanbase_name'];
        $fanbasePosts['post_count'][] = $row['post_count'];
    }
?>