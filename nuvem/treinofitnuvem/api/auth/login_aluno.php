<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

require "../config.php";
require "../util/response.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    response(false, null, "Método não permitido");
    exit;
}

try {
    
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

   
    if (empty($email) || empty($senha)) {
        response(false, null, "Dados incompletos");
        exit;
    }

   
    $stmt = $pdo->prepare("SELECT * FROM alunos WHERE email = ?");
    $stmt->execute([$email]);
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$aluno || !password_verify($senha, $aluno['senha'])) {
        response(false, null, "Email ou senha inválidos");
        exit;
    }

    unset($aluno['senha']);
    response(true, $aluno);

} catch (Exception $e) {
    http_response_code(500);
    response(false, null, "Erro no servidor: " . $e->getMessage());
}