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

// 운동 목록 가져오기
$query = "SELECT id, name FROM exercises";
$result = $db->query($query);
if (!$result) {
    die("Query failed: " . $db->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = $_POST['exercise_id'];
    $sets = $_POST['sets'];
    $weight = $_POST['weight'];
    $reps = $_POST['reps'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    // 운동 세션 추가
    $query = "INSERT INTO workout_sessions (user_id, date) VALUES (?, ?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $user_id, $date);
    $stmt->execute();
    $workout_session_id = $stmt->insert_id;
    $stmt->close();

    // 운동 로그 추가
    $query = "INSERT INTO exercise_logs (workout_session_id, exercise_id, sets, weight, reps, likes) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("iiiid", $workout_session_id, $exercise_id, $sets, $weight, $reps);
    if ($stmt->execute()) {
        echo "<script>
                alert('Exercise log added successfully.');
                window.location.href='date_detail.php?date=$date';
              </script>";
    } else {
        echo "<script>
                alert('Failed to add exercise log.');
                window.location.href='date_detail.php?date=$date';
              </script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exercise Log</title>
    <link rel="stylesheet" href="./css/login.css">
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
    <h2>Add Exercise Log</h2>
    <form method="post" action="add_exercise_log.php">
        <input type="hidden" name="date" value="<?php echo htmlspecialchars($_GET['date']); ?>">
        <div>
            <label for="exercise_id">Exercise Name:</label>
            <select id="exercise_id" name="exercise_id" required>
                <option value="" disabled selected>Select exercise</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label for="sets">Sets:</label>
            <input type="number" id="sets" name="sets" required>
        </div>
        <div>
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required>
        </div>
        <div>
            <label for="reps">Reps:</label>
            <input type="number" id="reps" name="reps" required>
        </div>
        <button type="submit">Add</button>
    </form>
</div>
</body>
</html>
