<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "로그인이 필요합니다.";
    exit;
}

$user_id = $_SESSION['user_id'];
$nickname = $_SESSION['nickname'];
$room_id = $user_id;

$message = $_POST['message'];

$conn = new mysqli('localhost', 'root', 'rlaekqls0217', 'project01');
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO chat_messages (user_id, message, room_id) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nickname, $message, $room_id);
$stmt->execute();
$conn->close();

header("Location: chat.php");
exit;
?>