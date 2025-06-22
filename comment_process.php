<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "로그인이 필요합니다.";
    exit;
}

$user_id = $_SESSION['user_id'];
$comment = $_POST['comment'];
$post_id = $_POST['post_id'];

$conn = new mysqli("localhost", "root", "rlaekqls0217", "project01");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $post_id, $user_id, $comment);

if ($stmt->execute()) {
    header("Location: community.php?id=$post_id");
    exit;
} else {
    echo "댓글 저장 실패: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
