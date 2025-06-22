<?php
session_start();
include 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "잘못된 접근입니다.";
    exit;
}
$id = intval($_GET['id']);

$conn = new mysqli("localhost", "root", "rlaekqls0217", "project01");
if ($conn->connect_error) die("DB 연결 실패");

$post = $conn->query("SELECT * FROM posts WHERE id = $id")->fetch_assoc();
if (!$post) {
    echo "존재하지 않는 글입니다.";
    exit;
}
$conn->query("UPDATE posts SET views = views + 1 WHERE id = $id");

$comments = $conn->query("
    SELECT c.comment_id, c.user_id, c.content, c.created_at, u.nickname
    FROM comments c
    JOIN users u ON c.user_id = u.user_id
    WHERE c.post_id = $id
    ORDER BY c.created_at ASC
");

// 좋아요 수 가져오기
$like_result = $conn->query("SELECT COUNT(*) as cnt FROM post_likes WHERE post_id = $id");
$like_row = $like_result->fetch_assoc();
$like_count = $like_row['cnt'] ?? 0;
?>

    <!-- 📦 게시글 박스 -->
    <div style="border: 2px solid #ccc; border-radius: 5px; padding: 15px; margin-top: 15px; background-color: #fdfdfd;">

        <!-- 제목 + 삭제 버튼 -->
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;"><?= htmlspecialchars($post['title']) ?></h2>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?');">
                    <button style="font-size: 0.9em;">삭제</button>
                </a>
            <?php endif; ?>
        </div>

        <!-- 작성자 / 날짜 / 조회수 -->
        <div style="font-size: 0.85em; color: gray; margin-top: 5px;">
            작성자: <?= htmlspecialchars($post['nickname'] ?? '') ?> |
            <?= $post['created_at'] ?? '' ?> |
            <?= $post['views'] ?? 0 ?>회 조회
        </div>

        <!-- 좋아요 수 + 버튼 -->
        <div style="margin-top: 10px; display: inline-flex; align-items: center;">
            <span>❤️ 좋아요 <?= $like_count ?>개</span>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $post['user_id']): ?>
                <a href="like_post.php?id=<?= $id ?>">
                    <button style="margin-left: 5px;">좋아요</button>
                </a>
            <?php endif; ?>
        </div>

        <hr>

        <!-- 본문 -->
        <p style="margin-top: 15px;"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    </div>


    <!-- 글 삭제/수정 -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
    <div style="margin-top: 15px;">
        <a href="edit.php?id=<?= $post['id'] ?>">
            <button>수정</button>
        </a>
        <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?');">
            <button>삭제</button>
        </a>
    </div>
    <?php endif; ?>

    

    <!-- 댓글 작성 박스 -->
    <div style="border: 1px solid #ccc; padding: 15px; margin-top: 20px; border-radius: 6px; background-color: #f9f9f9;">
        <h3 style="margin-top: 0;">댓글</h3>

        <form action="comment_process.php" method="post" style="display: flex; flex-direction: column; gap: 10px;">
            <input type="hidden" name="post_id" value="<?= $id ?>">

            <textarea name="comment" rows="4" placeholder="댓글 입력"
                style="resize: vertical; padding: 10px; border: 1px solid #aaa; border-radius: 4px; font-size: 1em;"></textarea>

            <button type="submit"
                style="align-self: flex-start; padding: 6px 12px; background-color: #eee; border: 1px solid #aaa; border-radius: 4px; cursor: pointer;">
                댓글 작성
            </button>
        </form>
    </div>

    <!-- 댓글 목록 -->
    <?php while ($c = $comments->fetch_assoc()): ?>
        <div style="border: 2px solid #ccc; border-radius: 5px; padding: 15px; margin-top: 15px; background-color: #fdfdfd;">
        <!-- 작성자와 삭제버튼 같은 줄 정렬 -->
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-weight: bold;"><?= htmlspecialchars($c['nickname']) ?></strong>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['user_id']): ?>
                <form action="delete_comment.php" method="get" onsubmit="return confirm('댓글을 삭제하시겠습니까?');" style="margin: 0;">
                    <input type="hidden" name="id" value="<?= $c['comment_id'] ?>">
                    <input type="hidden" name="post_id" value="<?= $id ?>">
                    <button type="submit" style="border: none; background: none; color: #888; cursor: pointer;">삭제</button>
                </form>
            <?php endif; ?>
        </div>

    <!-- 댓글 내용 -->
    <p style="margin: 10px 0 5px 0;"><?= nl2br(htmlspecialchars($c['content'])) ?></p>

    <!-- 댓글 시간 -->
    <div style="font-size: 0.85em; color: #777;"><?= $c['created_at'] ?></div>
</div>
<?php endwhile; ?>
