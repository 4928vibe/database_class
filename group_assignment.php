<html>
<head>
    <title>소모임</title>
</head>
<body>
<?php
    session_start();
    include("db.php");

    $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

    if (!$conn) {
        echo "DB 연결 실패";
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 세션에서 가져올 때는 존재 여부 확인이 중요합니다.
        if (isset($_SESSION['group_id']) && isset($_SESSION['user_id'])) {
            $group_id = intval($_SESSION['group_id']);
            $user_id = intval($_SESSION['user_id']);

            $sql = "INSERT INTO groups_members (group_id, user_id) VALUES ($group_id, $user_id)";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "참여 완료!";
            } else {
                echo "쿼리 오류: " . mysqli_error($conn);
            }
        } else {
            echo "세션에서 group_id 또는 user_id를 찾을 수 없습니다.";
        }
    }
    mysqli_close($conn);
?>
</body>
</html>
