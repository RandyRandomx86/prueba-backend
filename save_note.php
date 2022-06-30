<?php
session_start();
include('db.php');

if (isset($_POST['save_note'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $query = "";
  // $result = mysqli_query($conn, $query);
  $result = $conn->prepare('INSERT INTO notes(title, description,user_id) VALUES (:title,:description,:user_id)');
  $result->bindParam(':title', $_POST['title']);
  $result->bindParam(':description', $_POST['description']);
  $result->bindParam(':user_id', $_SESSION['id']);

  if (!$result->execute()) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Nota guardada';
  $_SESSION['message_type'] = 'success';
  header('Location: index.php');
}