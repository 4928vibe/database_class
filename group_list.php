<html>
<head>
    <title>소모임</title>
</head>
<body>
    <form method="POST" action="group_post.php"> <input type="submit" value="소모임 만들기"/> </form>
    <?php

        include("db.php");

        $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

        if(!$conn) {
            echo "db error";
            return;
        }

        // 카테고리 선택 필터
        $selected_category = isset($_GET['category']) ? $_GET['category'] : null;

        // 카테고리 리스트 출력
        $cat_sql = "SELECT * FROM group_catagories";
        $cat_result = mysqli_query($conn, $cat_sql);

        echo "<a href='group_list.php'>전체</a>";
        while ($cat = mysqli_fetch_assoc($cat_result)) {
            $cat_id = $cat['group_catagory_id'];
            $cat_name = $cat['name'];
            echo " | <a href='?category=$cat_id'>$cat_name</a>";
        }
        echo "<hr/>";

        if ($selected_category) {
            $sql = "SELECT group_id, title 
            FROM `group` 
            WHERE group_category_id = $selected_category 
            ORDER BY group_id DESC";
            } else {
            $sql = "SELECT group_id, title 
            FROM `group`
            ORDER BY group_id DESC";
            }

        $result = mysqli_query($conn, $sql);

        echo "<h2>소모임 리스트</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            $group_id = $row['group_id'];
            $title = $row['title'];
        
            echo "<a href='group.php?group_id=$group_id'>$title</a></br>";
}

        mysqli_close($conn);
    ?>

</body>
</html>