<?php
// connect to MySQL
$db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect. Check your connection parameters.');

//make sure you're using the correct database
mysqli_select_db($db, 'workout') or die(mysqli_error($db));

$query = 'ALTER TABLE exercise_logs ADD likes INT DEFAULT 0';

mysqli_query($db, $query) or die(mysqli_error($db));

echo 'Data inserted successfully!';
?>