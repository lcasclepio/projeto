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

    if (empty($cpf)) {
        response(false, null, "CPF não fornecido");
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM alunos WHERE cpf = ?");
    $stmt->execute([$cpf]);

    if ($stmt->rowCount() === 0) {
        response(false, null, "CPF não encontrado");
        exit;
    }

    response(true, true);
} catch (Exception $e) {
    http_response_code(500);
    response(false, null, "Erro no servidor: " . $e->getMessage());
}
