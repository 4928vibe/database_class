<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    exit;
}

$post_id = $_GET['id'] ?? null;

if (!$post_id || !is_numeric($post_id)) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) die("DB 연결 실패");

// 삭제 전: 글 작성자가 본인인지 확인
$stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row['user_id'] != $_SESSION['user_id']) {
        echo "<script>alert('본인 글만 삭제할 수 있습니다.'); history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('존재하지 않는 글입니다.'); history.back();</script>";
    exit;
}

// 실제 삭제
$del_stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$del_stmt->bind_param("i", $post_id);
$del_stmt->execute();

echo "<script>alert('글이 삭제되었습니다.'); location.href='community_list.php';</script>";
?>
