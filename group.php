<html>
<head>
    <title>소모임</title>
</head>
<body>
    <?php

        $db_host = "localhost";
        $db_user = "root";
        $db_pwd = "020227";
        $db_name = "project1";

        $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

        if(!$conn) {
            echo "db error";
            return;
        }

        $sql = "SELECT * FROM `group`
                LEFT JOIN regions ON `group`.region_id = regions.region_id
                LEFT JOIN group_catagories ON `group`.group_category_id = group_catagories.group_catagory_id
                LEFT JOIN week ON `group`.week = week.week";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            echo "지역 : ".$row['region_name']."<br/>";
            echo "분야 : ".$row['name']."<br/>";
            echo "요일 : ".$row['week_name']."<br/>";
            echo "시작 시간 : ".$row['start_time']."<br/>";
            echo "종료 시간 : ".$row['end_time']."<br/>";
            echo "회비 : 월 ".$row['price']." 원 <br/>";
            echo "정원 : ".$row['participants']." 명 <br/>";
            echo "모임명 : ".$row['title']."<br/>";
            echo "모집 글 : ".$row['description']."<br/>";
            echo "모집 상태 : ".$row['status']."<br/>";
        }

        mysqli_close($conn);
    ?>

</body>
</html>