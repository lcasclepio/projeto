<?php
session_name('TREINO_ALUNO');
session_start();
$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 42000, '/');
header("Location: ./login.php");
exit;
