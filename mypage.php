<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workout";

$db = new mysqli($servername, $username, $password, $dbname) or die ("Connection Error");

if (!isset($_SESSION['user_id'])) {
  echo "<script>
          alert('You are not logged in. Please log in.');
          window.location.href='login.html';
        </script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// 사용자 정보 조회
$query = "SELECT username, password FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Page</title>
  <link rel="stylesheet" href="./css/mypage.css">
</head>

<body>
  <h1>My Information</h1>
  <div class="user-info">
   <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
  </div>
  <div class="actions">
   <a href="edit_profile.php">Edit Profile</a>
   <a href="main.html">Home</a>
  </div>
</body>
</html>