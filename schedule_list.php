<!DOCTYPE html>
<html>
<head>
    <title>교육</title>
</head>
<body>

<?php
include("header.php");
include("db.php");
$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
$conn->set_charset("utf8");

if (!$conn) {
    echo "DB 연결 오류";
    return;
}

// 필터값 초기화
$selected_region = isset($_GET['region_id']) ? $_GET['region_id'] : '';
$selected_field = isset($_GET['field']) ? $_GET['field'] : '';
$selected_week = isset($_GET['week']) ? $_GET['week'] : '';
$selected_price = isset($_GET['price']) ? $_GET['price'] : '';
$selected_participants = isset($_GET['participants']) ? $_GET['participants'] : '';

// ✅ form 시작
echo "<form method='GET'>";

// 지역
echo "<h3>지역</h3>";
$sql = "SELECT schedule_category_id, name FROM schedule_categories WHERE category_type = 'region_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $value = $row['schedule_category_id'];
    $name = $row['name'];
    $checked = ($value == $selected_region) ? "checked" : "";
    echo "<label><input type='checkbox' name='region_id' value='$value' $checked> $name</label><br/>";
}

// 분야
echo "<h3>분야</h3>";
$sql = "SELECT schedule_category_id, name FROM schedule_categories WHERE category_type = 'field'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $value = $row['schedule_category_id'];
    $name = $row['name'];
    $checked = ($value == $selected_field) ? "checked" : "";
    echo "<label><input type='checkbox' name='field' value='$value' $checked> $name</label><br/>";
}

// 요일
echo "<h3>요일</h3>";
$sql = "SELECT schedule_category_id, name FROM schedule_categories WHERE category_type = 'week'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $value = $row['schedule_category_id'];
    $name = $row['name'];
    $checked = ($value == $selected_week) ? "checked" : "";
    echo "<label><input type='checkbox' name='week' value='$value' $checked> $name</label><br/>";
}

// 비용
echo "<h3>비용</h3>";
$sql = "SELECT schedule_category_id, name FROM schedule_categories WHERE category_type = 'price'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $value = $row['schedule_category_id'];
    $name = $row['name'];
    $checked = ($value == $selected_price) ? "checked" : "";
    echo "<label><input type='checkbox' name='price' value='$value' $checked> $name</label><br/>";
}

// 정원
echo "<h3>정원</h3>";
$sql = "SELECT schedule_category_id, name FROM schedule_categories WHERE category_type = 'participants'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $value = $row['schedule_category_id'];
    $name = $row['name'];
    $checked = ($value == $selected_participants) ? "checked" : "";
    echo "<label><input type='checkbox' name='participants' value='$value' $checked> $name</label><br/>";
}

echo "<br><input type='submit' value='검색'>";
echo "</form><hr/>";

// ✅ 조건 조합 (선택된 값만 where 절에 포함)
$where = [];
if ($selected_region !== '') $where[] = "region_id = '$selected_region'";
if ($selected_field !== '') $where[] = "field = '$selected_field'";
if ($selected_week !== '') $where[] = "week = '$selected_week'";
if ($selected_price !== '') $where[] = "price = '$selected_price'";
if ($selected_participants !== '') $where[] = "participants = '$selected_participants'";

$where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// ✅ 리스트 출력
$list_sql = "SELECT scheldule_id, name FROM schedule $where_sql ORDER BY scheldule_id DESC";
$list_result = mysqli_query($conn, $list_sql);

echo "<h3>스케줄 리스트</h3>";
if (mysqli_num_rows($list_result) == 0) {
    echo "조건에 맞는 스케줄이 없습니다.";
} else {
    while ($row = mysqli_fetch_assoc($list_result)) {
        echo "<a href='schedule.php?scheldule_id={$row['scheldule_id']}'>{$row['name']}</a><br/>";
    }
}

mysqli_close($conn);
?>

</body>
</html>
