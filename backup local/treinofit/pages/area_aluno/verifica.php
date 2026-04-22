<?php
session_name('TREINO_ALUNO');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['aluno_id'])) {
    header("Location: login.php");
    exit;
}
