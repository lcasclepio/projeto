<?php
session_name('TREINO_ALUNO');
session_start();
require "../../banco/conexao.php";

$cpf = $_POST['cpf'] ?? '';

if (empty($cpf)) {
    header("Location: confirmar_cpf.php?erro=1");
    exit;
}

$sql = "SELECT id FROM alunos WHERE cpf = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$cpf]);
$result = $stmt->fetchAll();

if (count($result) === 1) {
    $aluno = $result[0];
    $_SESSION['reset_aluno_id'] = $aluno['id'];

    header("Location: nova_senha.php");
    exit;
} else {
    header("Location: confirmar_cpf.php?erro=2");
    exit;
}
