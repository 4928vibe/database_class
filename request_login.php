<?php

    session_start();

    include("db.php");

    $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

   if(!$conn) {
    echo "db error";
} else {
    echo "succeed connect db";
    $id = $_POST["id"];
    $pwd = $_POST["pwd"];
}


    $sql = "select * from users where username='$id' and password='$pwd' ;";
    $result = mysqli_query($conn,$sql);

    $result_login=0;
    
    while($row = mysqli_fetch_array($result)){
        $result_login=1;
    }

    $link="";

    if($result_login)
        $link = "main.php";
    else
        $link = "login.php";

    echo("<script>location.replace('$link');</script>");

    mysqli_close($conn);

?>