<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$post_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$post_id || !is_numeric($post_id)) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 글 작성자와 동일하면 차단 (본인 글 좋아요 금지)
$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) die("DB 연결 실패");

$author_check = $conn->query("SELECT user_id FROM posts WHERE id = $post_id")->fetch_assoc();
if ($author_check && $author_check['user_id'] == $user_id) {
    echo "<script>alert('본인 게시물에는 좋아요를 누를 수 없습니다.'); history.back();</script>";
    exit;
}

// 이미 좋아요 했는지 확인
$check = $conn->prepare("SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?");
$check->bind_param("ii", $post_id, $user_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('이미 좋아요를 눌렀습니다.'); history.back();</script>";
    exit;
}

// 좋아요 추가
$stmt = $conn->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();

echo "<script>alert('좋아요가 추가되었습니다!'); location.href='community.php?id=$post_id';</script>";
