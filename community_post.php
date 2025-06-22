<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}
include 'header.php';

$conn = new mysqli("localhost", "root", "rlaekqls0217", "project01");
if ($conn->connect_error) die("DB 연결 실패");

// POST 요청 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $nickname = $_SESSION['nickname'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, nickname, title, content, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isss", $user_id, $nickname, $title, $content);

    if ($stmt->execute()) {
        header("Location: community_list.php");
        exit;
    } else {
        echo "작성 실패: " . $stmt->error;
    }
}
?>

<h2>글 작성</h2>
<form action="community_post.php" method="post">
    <label>제목</label><br>
    <input type="text" name="title" required><br><br>
    
    <label>내용</label><br>
    <textarea name="content" rows="10" required></textarea><br><br>
    
    <button type="submit">작성 완료</button>
</form>
