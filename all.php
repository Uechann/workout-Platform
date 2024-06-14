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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Work-Out</title>
  <link rel="stylesheet" href="./css/all.css">
</head>
<body>

<header>
  <h1>Work-Out Platform</h1>
  <div>
    <a href="main.html">Home</a>
    <a href="login.html">Login</a>
    <a href="mypage.php">My Page</a>
  </div>
</header>

<div class="calendar-container">
  <div class="calendar-header">
    <button id="prevBtn">이전</button>
    <h2 id="currentMonth"></h2>
    <button id="nextBtn">다음</button>
  </div>
  <div class="calendar-days">
    <div class="day">일</div>
    <div class="day">월</div>
    <div class="day">화</div>
    <div class="day">수</div>
    <div class="day">목</div>
    <div class="day">금</div>
    <div class="day">토</div>
  </div>
  <div class="calendar-dates" id="calendarDates"></div>
</div>

<script src="calendar.js"></script>

</body>
</html>