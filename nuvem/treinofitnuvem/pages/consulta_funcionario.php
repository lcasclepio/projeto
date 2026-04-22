<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";
require "../authentic/protego.php"; 

$busca = $_GET['busca'] ?? '';

if ($busca) {
    $queryBusca = $pdo->prepare(
        "SELECT * FROM funcionarios
         WHERE nome LIKE ? OR cpf LIKE ?"
    );
    $queryBusca->execute(["%$busca%", "%$busca%"]);
} else {
    $queryBusca = $pdo->query("SELECT * FROM funcionarios");
}

$funcionarios = $queryBusca->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Funcionários</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="consulta-container">
        <div class="consulta-header">
            <h1>Consulta de Funcionários</h1>
            <p>Visualize e gerencie os funcionários cadastrados</p>
        </div>

        <div class="search-box">
            <form method="get" class="search-form">
                <input type="text" name="busca" placeholder="Buscar CPF ou email" value="<?= htmlspecialchars($busca) ?>">
                <button type="submit">🔍 Pesquisar</button>
            </form>
        </div>

        <?php if (count($funcionarios) > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Cargo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funcionarios as $func): ?>
                        <tr>
                            <td><?= protego($func['nome']) ?></td>
                            <td><?= protego($func['sobrenome']) ?></td>
                            <td><?= protego($func['cpf']) ?></td>
                            <td><?= protego($func['email']) ?></td>
                            <td><?= protego($func['cargo']) ?></td>
                            <td>
                                <a href="perfil_funcionario.php?id=<?= $func['id'] ?>" class="btn-action btn-view">👁️ Ver Perfil</a>
                                <a href="alterar/funcionario.php?id=<?= $func['id'] ?>" class="btn-action btn-edit">✏️ Alterar</a>
                                <a href="excluir/funcionario.php?id=<?= $func['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">🗑️ Excluir</a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Nenhum funcionário encontrado.</p>
            </div>
        <?php endif; ?>

        <div class="consulta-footer">
            <a href="../home.php" class="btn-secondary">← Voltar</a>
        </div>
    </div>
</body>
</html>