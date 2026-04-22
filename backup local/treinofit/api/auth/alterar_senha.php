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
    
    $cpf = $_POST['cpf'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($senha) || empty($cpf)) {
        response(false, null, "Dados incompletos (CPF ou Senha ausentes)");
        exit;
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE alunos SET senha = ? WHERE cpf = ?");
    $stmt->execute([$hash, $cpf]);

    if ($stmt->rowCount() > 0) {
        response(true, true, "Senha alterada com sucesso");
    } else {
        response(false, null, "CPF não encontrado para alteração");
    }
} catch (Exception $e) {
    http_response_code(500);
    response(false, null, "Erro no servidor: " . $e->getMessage());
}