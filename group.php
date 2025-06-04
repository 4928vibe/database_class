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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $title = $_POST["title"];
        $description = $_POST["content"];
        $region_id = $_POST["region_id"];
        $group_category_id = $_POST["group_category_id"];
        $week = $_POST["week"];
        $start_time = $_POST["start_time"];
        $end_time = $_POST["end_time"];
        $price = $_POST["price"];
        $participants = $_POST["participants"];
        $images = "";
        $status = $_POST['status'];

        $sql = "INSERT INTO `group` (title, description, group_category_id, week, start_time, end_time, price, participants, images, status, region_id)
                VALUES ('$title', '$description', '$group_category_id', '$week', '$start_time', '$end_time', '$price', '$participants', '$images', '$status', '$region_id')";
        $result = mysqli_query($conn, $sql);
        
        }

        if ($_GET['group_id'] !== '') {
            $group_id = $_GET['group_id'];

        $sql = "SELECT * FROM `group`
                LEFT JOIN regions ON `group`.region_id = regions.region_id
                LEFT JOIN group_catagories ON `group`.group_category_id = group_catagories.group_catagory_id
                LEFT JOIN week ON `group`.week = week.week
                WHERE `group`.group_id = $group_id";

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
    }
        mysqli_close($conn);
    ?>

    <form method="POST" action="group_assignment.php"> <input type="submit" value="신청하기"/> </form>

</body>
</html>