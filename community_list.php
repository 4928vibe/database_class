<?php
include 'header.php';
include("db.php");

$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) die("DB 연결 실패");

$sql = "SELECT id, title, nickname, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!-- 커뮤니티 제목 + 글쓰기 버튼 같은 줄 정렬 -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <h2 style="margin: 0;">커뮤니티 게시판</h2>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="community_post.php">
            <button style="padding: 6px 12px;">글쓰기</button>
        </a>
    <?php endif; ?>
</div>

<!-- 전체 글 목록 큰 박스 -->
<div style="border: 2px solid #ccc; padding: 20px; border-radius: 6px; background-color: #fdfdfd;">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div style="padding: 12px 0; border-bottom: 1px solid #ddd;">
                <!-- 제목 -->
                <a href="community.php?id=<?= $row['id'] ?>" style="font-size: 1.1em; font-weight: bold; text-decoration: none; color: black;">
                    <?= htmlspecialchars($row['title']) ?>
                </a>
                <!-- 작성자 / 날짜 -->
                <div style="font-size: 0.85em; color: gray; margin-top: 4px;">
                    <?= htmlspecialchars($row['nickname']) ?> | <?= $row['created_at'] ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>게시글이 없습니다.</p>
    <?php endif; ?>
</div>
