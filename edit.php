<?php
session_start();
include("db.php");
$title = '';
$description = '';
$id = $_GET['id'];

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $records  = $conn->prepare('SELECT * FROM notes WHERE id=:id');
  $records->bindParam(':id', $id);
  $records->execute();
  $result_notes = $records->fetch(PDO::FETCH_ASSOC);
  if (is_countable($result_notes)) {
    $row = $result_notes;
    $title = $row['title'];
    $description = $row['description'];
  }
}

if (isset($_POST['update'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];

  $result = $conn->prepare('UPDATE notes set title=:title, description=:description WHERE id=:id');
  $result->bindParam(':id', $id);
  $result->bindParam(':title', $title);
  $result->bindParam(':description', $description);
  $result->execute();
  $_SESSION['message'] = 'Nota actualizada';
  $_SESSION['message_type'] = 'warning';
  header('Location: index.php');
}

?>
<?php include('includes/header.php'); ?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <input name="title" type="text" class="form-control" value="<?php echo $title; ?>"
                            placeholder="Título">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" cols="30" rows="10"
                            placeholder="Descripción"><?php echo $description; ?></textarea>
                    </div>
                    <button class="btn-success" name="update">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>