<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";
require "../authentic/protego.php"; 

$idFuncionario = $_GET['id'] ?? null;

if (!$idFuncionario) {
    echo "Funcionário não informado.";
    exit;
}

$sqlFuncionario = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
$sqlFuncionario->execute([$idFuncionario]);
$funcionario = $sqlFuncionario->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Funcionário</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="perfil-container">
        <div class="perfil-header">
            <h1>Perfil do Funcionário</h1>
            <p>Informações do funcionário</p>
        </div>

        <div class="perfil-card">
            <div class="perfil-info">
                <div class="info-group">
                    <label>Nome</label>
                    <p><?= protego($funcionario['nome']) ?></p>
                </div>

                <div class="info-group">
                    <label>Sobrenome</label>
                    <p><?= protego($funcionario['sobrenome']) ?></p>
                </div>

                <div class="info-group">
                    <label>CPF</label>
                    <p><?= protego($funcionario['cpf']) ?></p>
                </div>

                <div class="info-group">
                    <label>Email</label>
                    <p><?= protego($funcionario['email']) ?></p>
                </div>

                <div class="info-group">
                    <label>Cargo</label>
                    <p><?= protego($funcionario['cargo']) ?></p>
                </div>
            </div>
        </div>

        <div class="perfil-actions">
            <a href="consulta_funcionario.php" class="btn-secondary">← Voltar</a>
            <a href="../home.php" class="btn-primary">🏠 Página Inicial</a>
        </div>
    </div>
</body>
</html>