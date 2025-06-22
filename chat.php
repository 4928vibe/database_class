<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nickname'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$room_id = $_SESSION['user_id'];
$nickname = $_SESSION['nickname'];

// DB 연결
$conn = new mysqli('localhost', 'root', 'rlaekqls0217', 'project01');
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 메시지 불러오기
$result = $conn->query("SELECT * FROM chat_messages ORDER BY created_at DESC LIMIT 50");
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>채팅방</title>
</head>
<body>

<!-- 전체 채팅 박스 -->
<div style="max-width: 600px; margin: 30px auto; border: 1px solid #ccc; border-radius: 6px; padding: 20px; background-color: #fdfdfd;">

    <!-- 상단 타이틀 + 나가기 버튼 -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <strong><?= htmlspecialchars($nickname) ?>님의 채팅방</strong>
        <a href="main.php">
            <button style="padding: 6px 10px; font-size: 0.9em;">나가기</button>
        </a>
    </div>

    <!-- 채팅 입력창 -->
    <form action="send_chat.php" method="post" style="display: flex; gap: 5px; margin-bottom: 15px;">
        <input type="text" name="message" placeholder="메시지를 입력하세요" required
            style="flex: 1; padding: 8px; border: 1px solid #aaa; border-radius: 4px;">
        <button type="submit" style="padding: 8px 12px;">전송</button>
    </form>

    <hr style="margin: 10px 0;">

    <!-- 채팅 메시지 출력 -->
    <div style="font-size: 0.95em; line-height: 1.8;">
        <?php foreach (array_reverse($messages) as $msg): ?>
            <div>
                <strong><?= htmlspecialchars($msg['user_id']) ?></strong>
                [<?= $msg['created_at'] ?>]: <?= htmlspecialchars($msg['message']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
