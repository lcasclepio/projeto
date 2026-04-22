<?php
require "../../banco/conexao.php";
require "../../authentic/verifica_login.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../consulta_funcionario.php");
exit;
