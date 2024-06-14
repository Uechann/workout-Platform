<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workout";

$db = new mysqli($servername, $username, $password, $dbname) or die("Connection failed : " . $db->connect_error);

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You are not logged in. Please log in.');
            window.location.href='login.html';
          </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $query = "UPDATE users SET username = ?, password = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssi", $inputUsername, $inputPassword, $user_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href='mypage.php';
              </script>";
    } else {
        echo "<script>
                alert('Profile update failed. Please try again.');
                window.location.href='edit_profile.php';
              </script>";
    }

    $stmt->close();
}

$db->close();
?>
