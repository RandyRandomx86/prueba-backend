<?php
session_start();
include('db.php');

$message = '';
if (!empty($_POST['name']) && !empty($_POST['user']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
  if ($_POST['password'] == $_POST['confirm_password']) {
    $sql = "INSERT INTO users (name,user_name,email,password) VALUES (:name,:user,:email,:password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':user', $_POST['user']);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $alert = "";
    if ($stmt->execute()) {
      $message = '¡Usuario creado exitosamente!';
      $alert = "success";
    } else {
      $message = 'Hubo un error al crear el usuario';
      $alert = "danger";
    }
  } else {
    $message = 'Las contraseñas no coinciden';
    $alert = "danger";
  }
}
include('includes/header.php');
?>

<!-- <body> -->

<?php if (!empty($message)) : ?>
<div class="alert alert-<?php echo $alert; ?>" role="alert">
    <?= $message  ?>
    <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>
<br>
<h1 class="custom_form">Crear una cuenta</h1><br>
<div class="custom_form">¿Ya tienes una cuenta? <a href="./login.php">Ingresar</a></div class="custom_form">
<form action="signup.php" class="custom_form" method="post">
    <input type="text" name="name" class="custom_input" placeholder="Ingresa tu nombre">
    <input type="text" name="user" class="custom_input" placeholder="Ingresa un nombre usuario">
    <input type="email" name="email" class="custom_input" placeholder="Ingresa tu correo">
    <input type="password" name="password" class="custom_input" placeholder="Ingresa tu contraseña">
    <input type="password" name="confirm_password" class="custom_input" placeholder="Repite tu contraseña">
    <input type="submit" value="Registrar" class="custom_submit">
</form>

<?php include('includes/footer.php'); ?>