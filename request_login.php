<?php
session_start();
include("db.php");

// DB 연결
$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$id = $_POST["id"];
$pwd = $_POST["pwd"];

$sql = "SELECT user_id, nickname FROM users WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $pwd);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['nickname'] = $row['nickname']; 
    $_SESSION['group_id'] = $row['group_id']; 
    header("Location: main.php"); 
    exit;
} else {
    echo "<script>alert('로그인 실패: 아이디 또는 비밀번호가 틀렸습니다.');";
    echo "location.replace('login.php');</script>";
    exit;
}

$conn->close();
?>