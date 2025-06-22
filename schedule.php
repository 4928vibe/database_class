<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>프로그램 상세보기</title>
</head>
<body>

<?php
include("db.php");

$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if (!$conn) {
    echo "DB 연결 오류";
    exit;
}

if (isset($_GET['scheldule_id']) && $_GET['scheldule_id'] !== '') {
    $scheldule_id = intval($_GET['scheldule_id']);

    $sql = "SELECT schedule.*, 
                   regions.region_name, 
                   week.week_name 
            FROM schedule
            LEFT JOIN regions ON schedule.region_id = regions.region_id
            LEFT JOIN week ON schedule.week = week.week
            WHERE schedule.scheldule_id = $scheldule_id";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        // 이미지 출력
        if (!empty($row['image'])) {
            echo "<img src='/images/" . htmlspecialchars($row['image']) . "' alt='프로그램 이미지' width='300'><br/><br/>";
        }

        echo "지역 : " . $row['region_name'] . "<br/>";
        echo "분야 : " . $row['field'] . "<br/>";
        echo "요일 : " . $row['week_name'] . "<br/>";
        echo "시작 시간 : " . $row['start_time'] . "<br/>";
        echo "종료 시간 : " . $row['end_time'] . "<br/>";
        echo "회비 : 월 " . $row['price'] . " 원<br/>";
        echo "정원 : " . $row['participants'] . " 명<br/>";
        echo "모임명 : " . $row['name'] . "<br/>";
        echo "모집 글 : " . nl2br(htmlspecialchars($row['content'])) . "<br/>";
        echo "모집 상태 : " . ($row['status'] == 1 ? "모집 중" : "마감") . "<br/>";
    } else {
        echo "<p>해당 프로그램을 찾을 수 없습니다.</p>";
    }
}
mysqli_close($conn);
?>

<!-- 신청 버튼 -->
<br/>
<form method="POST" action="schedule_apply.php">
    <input type="hidden" name="scheldule_id" value="<?= htmlspecialchars($scheldule_id) ?>">
    <input type="submit" value="신청하기">
</form>

</body>
</html>
