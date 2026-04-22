<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

require "../config.php";
require "../util/response.php";

$treino_id = $_POST['treino_id'] ?? 0;

if ($treino_id == 0) {
    response(false, null, "ID do treino não fornecido");
    exit;
}

try {
   
    $stmtTreino = $pdo->prepare("SELECT id, observacao_geral, data_treino FROM treinos WHERE id = ?");
    $stmtTreino->execute([$treino_id]);
    $treinoInfo = $stmtTreino->fetch(PDO::FETCH_ASSOC);

    if (!$treinoInfo) {
        response(false, null, "Treino não encontrado");
        exit;
    }


    $stmtEx = $pdo->prepare("
        SELECT 
            e.nome AS nome, 
            te.comentario AS comentario,
            '--' AS series,      -- Seu banco não tem essa coluna, enviamos '--'
            '--' AS repeticoes   -- Seu banco não tem essa coluna, enviamos '--'
        FROM treino_exercicios te
        INNER JOIN exercicios e ON te.exercicio_id = e.id
        WHERE te.treino_id = ?
    ");
    $stmtEx->execute([$treino_id]);
    $exercicios = $stmtEx->fetchAll(PDO::FETCH_ASSOC);

    $resultado = [
        "id" => $treinoInfo['id'],
        "nome" => "Treino #" . $treinoInfo['id'],
        "observacao_geral" => $treinoInfo['observacao_geral'] ?? "",
        "exercicios" => $exercicios
    ];

    response(true, $resultado);

} catch (Exception $e) {
    response(false, null, "Erro: " . $e->getMessage());
}