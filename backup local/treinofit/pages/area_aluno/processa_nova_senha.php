<?php
session_name('TREINO_ALUNO');
session_start();
require "../../banco/conexao.php";

if (!isset($_SESSION['reset_aluno_id'])) {
    header("Location: login.php");
    exit;
}

$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($senha !== $confirmar) {
    header("Location: nova_senha.php?erro=1");
    exit;
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "UPDATE alunos SET senha = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$senha_hash, $_SESSION['reset_aluno_id']]);

unset($_SESSION['reset_aluno_id']);

header("Location: nova_senha.php?sucesso=1");
exit;
