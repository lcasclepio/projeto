<?php
session_name('TREINO_ALUNO');
session_start();
require "../../banco/conexao.php";

if (isset($_SESSION['aluno_id']) && $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: home.php");
    exit;
}

$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

if (empty($email) || empty($senha)) {
    header("Location: ./login.php?erro=vazio");
    exit;
}

try {
    $autentic = $pdo->prepare("SELECT id, nome, senha FROM alunos WHERE email = ?");
    $autentic->execute([$email]);
    $aluno = $autentic->fetch(PDO::FETCH_ASSOC);

    if ($aluno && password_verify($senha, $aluno['senha'])) {
        $_SESSION['aluno_id']   = $aluno['id'];
        $_SESSION['aluno_nome'] = $aluno['nome'];
        header("Location: ./home.php");
        exit;
    }

    header("Location: login.php?erro=login_invalido");
    exit;

} catch (PDOException $e) {
    header("Location: login.php?erro=sistema");
    exit;
}
