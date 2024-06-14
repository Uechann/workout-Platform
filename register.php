<?php
//database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workout";

//to mysql database connetion
$db = new mysqli($servername, $username, $password, $dbname) or die("Connection failed : " . db->connect_error);

// POST 요청으로부터 데이터 가져오기
$inputUsername = $_POST['username'];
$inputPassword = $_POST['password'];

// 입력된 데이터의 유효성 검사
if (empty($inputUsername) || empty($inputPassword)) {
    echo "<script>
            alert('input your id and password.');
            window.history.back();
          </script>";
    exit();
}

// 아이디 중복 확인
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $inputUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 아이디 중복
    echo "<script>
            alert('it's already exist id. Use the other id.');
            window.history.back();
          </script>";
    exit();
}

// 새로운 사용자 추가
$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $inputUsername, $inputPassword);

if ($stmt->execute()) {
    // 회원가입 성공
    echo "<script>
            alert('Register Successfully! Login Please');
            window.location.href = 'login.html';
          </script>";
} else {
    // 회원가입 실패
    echo "<script>
            alert('failed. Try again.');
            window.history.back();
          </script>";
}

// 연결 종료
$db->close();
?>