<?php
session_name('TREINO_ADMIN');
session_start();
$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 42000, '/');
header("Location:autenticar.php");
exit;
