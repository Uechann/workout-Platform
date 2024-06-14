<?php
// connect to MySQL
$db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect. Check your connection parameters.');

//make sure you're using the correct database
mysqli_select_db($db, 'workout') or die(mysqli_error($db));

// insert data into the target_areas table
//$query = 'INSERT INTO target_areas (name) VALUES
 // ("Chest"),
  //("Back"),
 // ("Legs")';
//mysqli_query($db, $query) or die(mysqli_error($db));

// insert data into the movietype table
$query = 'INSERT INTO exercises (target_area_id, name) VALUES 
(1, "Bench Press"),
(1, "Pec Deck Fly"),
(1, "Incline Bench Press"),
(2, "Deadlift"),
(2, "barbell row"),
(2, "Pull-Up"),
(3, "Squat"),
(3, "Leg Press"),
(3, "Leg extention")';
mysqli_query($db, $query) or die(mysqli_error($db));

echo 'Data inserted successfully!';
?>