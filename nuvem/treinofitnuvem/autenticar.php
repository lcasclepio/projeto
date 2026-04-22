<?php
session_start();
require "banco/conexao.php";


if (isset($_SESSION['funcionario_id']) && $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

if (empty($email) || empty($senha)) {
    header("Location: index.php?erro=vazio");
    exit;
}

try {
    $autentic = $pdo->prepare("SELECT id, nome, senha FROM funcionarios WHERE email = ?");
    $autentic->execute([$email]);
    $funcionario = $autentic->fetch(PDO::FETCH_ASSOC);

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        
        $_SESSION['funcionario_id']   = $funcionario['id'];
        $_SESSION['funcionario_nome'] = $funcionario['nome'];

        header("Location: home.php");
        exit;
    } 
    header("Location: index.php?erro=login_invalido");
    exit;

} catch (PDOException $e) {
    header("Location: index.php?erro=sistema");
    exit;
}