<?php
session_start();
include("db.php");
if (isset($_SESSION['id'])) {
  header('Location: index.php');
}

if (isset($_POST['user']) && isset($_POST['password'])) {
  $records = $conn->prepare('SELECT id,user_name,password FROM users WHERE user_name=:user');
  $records->bindParam(':user', $_POST['user']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);
  $message = '';

  if (is_countable($results) && password_verify($_POST["password"], $results["password"])) {
    $_SESSION['id'] = $results['id'];
    header('Location: index.php');
  } else {
    $message = "Los datos introducidos no coinciden con algun registro";
  }
}
include('./includes/header.php')
?>
<?php if (isset($message)) : ?>
<div class="alert alert-danger" role="alert">
    <?= $message  ?>
    <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif ?>
<br><br><br>
<h1 class="custom_form">Ingreso al sistema</h1><br>
<div class="custom_form">¿No tienes una cuenta? <a href="signup.php">Regístrate</a></div>

<form action="login.php" class="custom_form" method="post">
    <input type="text" class="custom_input" name="user" placeholder="Ingresa tu usuario">
    <input type="password" name="password" class="custom_input" placeholder="Ingresa tu contraseña">
    <input type="submit" value="Ingresar" class="custom_submit">
</form>
<?php include('./includes/footer.php'); ?>