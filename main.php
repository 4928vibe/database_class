<?php
session_start();
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>메인 홈페이지</title>
</head>
<body>

<div>
    <a href="chat.php">
        <button>채팅</button>
    </a>
</div>

<!-- 전체 메인 콘텐츠 박스 -->
<div style="max-width: 800px; margin: 30px auto; border: 1px solid #ccc; padding: 25px; border-radius: 6px; background-color: #fdfdfd;">

    <!-- 최신 정보 -->
    <h3 style="margin-top: 0;">📌 최신 정보</h3>
    <ul style="padding-left: 20px; line-height: 1.8;">
        <li>최신 정보 글입니다. 25.04.13</li>
    </ul>

    <!-- 실시간 인기 글 -->
    <h3 style="margin-top: 30px;">🔥 실시간 인기 글</h3>
    <ul style="padding-left: 20px; line-height: 1.8;">
        <li>실시간 인기 글입니다. 좋아요 13개</li>
    </ul>

</div>


</body>
</html>