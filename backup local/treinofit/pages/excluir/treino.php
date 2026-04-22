<?php
header('Content-Type: application/json');
require "../../banco/conexao.php";
require "../../authentic/verifica_login.php";

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $pdo->prepare("DELETE FROM treino_exercicios WHERE treino_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM treinos WHERE id = ?")->execute([$id]);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Treino apagado com sucesso!']);
    } catch (Exception $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao apagar treino']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do treino não informado']);
}
