<html>
    <head>
        <title>댓글</title>
</head>

        <body> 
            <form method="POST" action="comment.php">
                댓글 : <input type = "text" name="comment"/>
                <input type = "submit" name="submit"/>
            </form>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo "댓글 : ".$_POST['comment']."<br/>";
                    }
                    else{
                        //echo "댓글이 없습니다.";
                    }

                ?>
    
        </body>
</html>