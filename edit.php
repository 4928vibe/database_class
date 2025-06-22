<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$conn = new mysqli("localhost", "root", "rlaekqls0217", "project01");
if ($conn->connect_error) die("DB 연결 실패");

// POST 처리: 수정 완료
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // 본인 글인지 확인
    $check = $conn->query("SELECT * FROM posts WHERE id = $id AND user_id = '$user_id'");
    if ($check->num_rows === 0) {
        echo "수정 권한이 없습니다.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        header("Location: community.php?id=" . $id);
        exit;
    } else {
        echo "수정 실패: " . $stmt->error;
    }
    exit;
}

// GET 처리: 수정 폼 보여주기
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "잘못된 접근입니다.";
    exit;
}

$id = intval($_GET['id']);
$post = $conn->query("SELECT * FROM posts WHERE id = $id")->fetch_assoc();
if (!$post || $post['user_id'] != $_SESSION['user_id']) {
    echo "수정 권한이 없습니다.";
    exit;
}
?>

<h2>게시글 수정</h2>
<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?= $post['id'] ?>">

    <label>제목</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>

    <label>내용</label><br>
    <textarea name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>

    <button type="submit">수정 완료</button>
</form>
