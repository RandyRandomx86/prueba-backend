<?php
session_start();
include("db.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $result = $conn->prepare('DELETE FROM notes WHERE id=:id');
  $result->bindParam(':id', $id);

  if (!$result->execute()) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Nota eliminada';
  $_SESSION['message_type'] = 'danger';
  header('Location: index.php');
}