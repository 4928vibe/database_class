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

        mysqli_close($conn);
    ?>

</body>
</html>