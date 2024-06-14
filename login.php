<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workout";

$db = new mysqli($servername, $username, $password, $dbname) or die ("Connection Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";//플레이스 홀더 나중에 값으로 대체
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $inputUsername);//? 값이 대체 됨
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($inputPassword == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<script>
                    alert('Login successful!');
                    window.location.href='main.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Login failed : Incorrect password. Please try again or click register');
                    window.location.href='login.html';
                  </script>";
        }
    } else {
        echo "<script>alert('Login failed: Username not found. Please register.');
        window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$db->close();
?>
