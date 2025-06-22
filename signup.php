<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $nickname = trim($_POST["nickname"]);

    if ($password !== $password2) {
        $message = "❌ 비밀번호가 일치하지 않습니다.";
    } elseif (strlen($username) < 4 || strlen($password) < 4 || strlen($nickname) < 1) {
        $message = "❌ 아이디는 4자 이상, 비밀번호는 4자 이상, 닉네임은 1자 이상이어야 합니다.";
    } else {
        $conn = new mysqli("localhost", "root", "rlaekqls0217", "project01");
        if ($conn->connect_error) {
            die("DB 연결 실패: " . $conn->connect_error);
        }

        // ❗ 비밀번호를 암호화x
        $stmt = $conn->prepare("INSERT INTO users (username, password, nickname) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $nickname);

        if ($stmt->execute()) {
            $message = "✅ 회원가입 성공! <a href='login.php'>로그인하러 가기</a>";
        } else {
            $message = "❌ 회원가입 실패: 이미 존재하는 아이디입니다다.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원가입</title>
</head>
<body>
    <h2>회원가입</h2>
    <form method="POST">
        <label>아이디: <input type="text" name="username" required></label><br>
        <label>비밀번호: <input type="password" name="password" required></label><br>
        <label>비밀번호 확인: <input type="password" name="password2" required></label><br>
        <label>닉네임: <input type="text" name="nickname" required></label><br>
        <button type="submit">가입하기</button>
    </form>
    <p><?= $message ?></p>
</body>
</html>
