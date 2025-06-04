<html>
<head>
    <title>소모임</title>
</head>
<body>
    <?php
        session_start();

        include("db.php");

        $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

        if(!$conn) {
            echo "db error";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $group_id = $_0['group_id'];
            $user_id = $_SESSION['user_id'];
        }

            $sql = "INSERT INTO groups_members (group_id, user_id) VALUES ($group_id, $user_id)";
            $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
    ?>

</body>
</html>