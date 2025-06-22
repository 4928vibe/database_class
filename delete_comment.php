<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$comment_id = $_GET['id'] ?? null;
$post_id = $_GET['post_id'] ?? null;

if (!$comment_id || !$post_id || !is_numeric($comment_id) || !is_numeric($post_id)) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) die("DB 연결 실패");

// 댓글 작성자 확인
$stmt = $conn->prepare("SELECT user_id FROM comments WHERE comment_id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row['user_id'] != $_SESSION['user_id']) {
        echo "<script>alert('본인 댓글만 삭제할 수 있습니다.'); history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('존재하지 않는 댓글입니다.'); history.back();</script>";
    exit;
}

// 삭제 실행
$del = $conn->prepare("DELETE FROM comments WHERE comment_id = ?");
$del->bind_param("i", $comment_id);
$del->execute();

echo "<script>alert('댓글이 삭제되었습니다.'); location.href='community.php?id=$post_id';</script>";
?>
