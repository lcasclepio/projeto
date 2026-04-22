<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

require "../config.php";
require "../util/response.php";

$aluno_id = $_POST['aluno_id'] ?? 0;

if ($aluno_id == 0) {
    response(false, null, "ID do aluno não fornecido");
    exit;
}

try {
   
    $stmt = $pdo->prepare("SELECT id, observacao_geral, data_treino FROM treinos WHERE aluno_id = ? ORDER BY data_treino DESC");
    $stmt->execute([$aluno_id]);
    $treinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    foreach($treinos as &$t) {
        $t['nome'] = "Treino do dia " . date('d/m', strtotime($t['data_treino']));
    }

    response(true, ["treinos" => $treinos]);
} catch (Exception $e) {
    response(false, null, $e->getMessage());
}