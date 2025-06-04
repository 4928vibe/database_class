<html>
<head>
    <title>소모임</title>
</head>
<body>
    <?php

        include("db.php");

        $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

        if(!$conn) {
            echo "db error";
            return;
        }

        $sql = "SELECT group_id, title FROM `group` ORDER BY group_id DESC";
        $result = mysqli_query($conn, $sql);

        echo "<h2>소모임 리스트</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            $group_id = $row['group_id'];
            $title = $row['title'];
        
            echo "<a href='group.php?group_id=$group_id'>$title</a></br>";
}

        mysqli_close($conn);
    ?>

</body>
</html>