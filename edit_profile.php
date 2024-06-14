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
  <title>Edit Profile</title>
  <link rel="stylesheet" href="./css/mypage.css">
</head>
<body>
  <h1>Edit My Information</h1>
  <form action="update_profile.php" method="post">
    <div>
      <label>Username <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></label>
    </div>
    <div>
      <label>Password <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>"></label>
    </div>
    <div>
      <button type="submit">Update</button>
      <a href="mypage.php">Cancel</a>
    </div>
  </form>
  
</body>
</html>
