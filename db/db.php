<?php
$db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect. Check your connection parameters.');

//create database
$query = 'CREATE DATABASE IF NOT EXISTS workout';
mysqli_query($db, $query) or die(mysqli_error($db));
mysqli_select_db($db, 'workout') or die(mysqli_error($db));

//create users table
$query = 'CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
)
ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));

//create the workout_sessions table
$query = 'CREATE TABLE workout_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  date DATE NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
  )

  ENGINE=MyISAM';
  mysqli_query($db, $query) or die(mysqli_error($db));
  
  //create target_areas table
  $query = 'CREATE TABLE target_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
  )

  ENGINE=MyISAM';
  mysqli_query($db, $query) or die(mysqli_error($db));

  //create exercises table
  $query = 'CREATE TABLE exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    target_area_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (target_area_id) REFERENCES target_areas(id)
  )

  ENGINE=MyISAM';
  mysqli_query($db, $query) or die(mysqli_error($db));

  //create exercise_logs table
  $query = 'CREATE TABLE exercise_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    workout_session_id INT NOT NULL,
    exercise_id INT NOT NULL,
    sets INT NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    reps INT NOT NULL,
    FOREIGN KEY (workout_session_id) REFERENCES workout_sessions(id),
    FOREIGN KEY (exercise_id) REFERENCES exercises(id)
  )

  ENGINE=MyISAM';
  mysqli_query($db, $query) or die(mysqli_error($db));
  echo 'workout database successfully created!';
?>