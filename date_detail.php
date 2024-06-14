<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workout";

$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You are not logged in. Please log in.');
            window.location.href='login.html';
          </script>";
    exit();
}

if (isset($_POST['log_id'])) {
    $log_id = $_POST['log_id'];
    $user_id = $_SESSION['user_id'];

    // 좋아요 수 증가 쿼리
    $query = "UPDATE exercise_logs SET likes = likes + 1 WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $log_id);
    if ($stmt->execute()) {
        echo "<script>alert('Like increased.');</script>";
    } else {
        echo "<script>alert('Like increase failed.');</script>";
    }
    $stmt->close();
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // 운동 기록 조회 쿼리
    $query = 'SELECT el.*, e.name AS exercise_name, u.username AS user_name
              FROM exercise_logs el
              JOIN exercises e ON el.exercise_id = e.id
              JOIN workout_sessions ws ON el.workout_session_id = ws.id
              JOIN users u ON ws.user_id = u.id
              WHERE ws.date = ?';

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "<script>alert('Incorrect access.'); window.location.href='main.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Details</title>
    <link rel="stylesheet" href="./css/all.css">
</head>
<body>
<header>
    <h1>Work-out Platform</h1>
    <div>
        <a href="main.html">Home</a>
        <a href="login.html">Login</a>
        <a href="mypage.php">Mypage</a>
    </div>
</header>

<div class="exercise-log-container">
    <h2><?php echo htmlspecialchars($date); ?> Workout</h2>
    <div class="addbutton">
        <button onclick="window.location.href='add_exercise_log.php?date=<?php echo htmlspecialchars($date); ?>'">Add Workout</button>
    </div>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    User Name: <?php echo htmlspecialchars($row['user_name']); ?><br>
                    Exercise Name: <?php echo htmlspecialchars($row['exercise_name']); ?><br>
                    Sets: <?php echo htmlspecialchars($row['sets']); ?><br>
                    Weight (kg): <?php echo htmlspecialchars($row['weight']); ?><br>
                    Reps: <?php echo htmlspecialchars($row['reps']); ?><br>
                    Likes: <?php echo htmlspecialchars($row['likes']); ?><br>
                    <form method="post" action="date_detail.php?date=<?php echo htmlspecialchars($date); ?>">
                        <input type="hidden" name="log_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Like</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No data for this day.</p>
    <?php endif; ?>
</div>
</body>
</html>
