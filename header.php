<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- 💡 상단 전체 헤더 박스 -->
<div style="border-bottom: 1px solid #ccc; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center;">

    <!-- 좌측: 로고 + 검색창 -->
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="로고.png" alt="로고" style="height: 40px;">
        <form action="#" method="get" style="display: flex; align-items: center;">
            <input type="text" placeholder="검색어를 입력하세요..." style="padding: 5px; border: 1px solid #aaa; border-radius: 4px;">
            <button type="submit" style="margin-left: 5px; padding: 5px 10px;">검색</button>
        </form>
    </div>

    <!-- 우측: 로그인 상태 -->
    <div style="font-size: 0.95em;">
        <?php if (isset($_SESSION['nickname'])): ?>
            <?= htmlspecialchars($_SESSION['nickname']) ?>님 |
            <a href="logout.php" style="color: purple; text-decoration: none;">로그아웃</a>
        <?php else: ?>
            <a href="login.php" style="margin-right: 10px;">로그인</a>
            <a href="signup.php">회원가입</a>
        <?php endif; ?>
    </div>
</div>

<!-- 메뉴 네비게이션 -->
<nav style="padding: 10px 30px; background-color: #fafafa; border-bottom: 1px solid #eee;">
    <a href="main.php" style="margin-right: 20px; text-decoration: none; color: #333;">홈</a>
    <a href="schedule_list.php" style="margin-right: 20px; text-decoration: none; color: #333;">교육</a>
    <a href="group_list.php" style="margin-right: 20px; text-decoration: none; color: #333;">소모임</a>
    <a href="community_list.php" style="text-decoration: none; color: #663399;">커뮤니티</a>
</nav>
