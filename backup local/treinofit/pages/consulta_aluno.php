<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";
require "../authentic/protego.php"; 

$busca = $_GET['busca'] ?? '';

if ($busca) {
    $consulta = $pdo->prepare(
        "SELECT * FROM alunos 
         WHERE nome LIKE ? OR cpf LIKE ?"
    );
    $consulta->execute(["%$busca%", "%$busca%"]);
} else {
    $consulta = $pdo->query("SELECT * FROM alunos");
}

$alunos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Alunos</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="consulta-container">
        <div class="consulta-header">
            <h1>Consulta de Alunos</h1>
            <p>Visualize e gerencie os alunos cadastrados</p>
        </div>

        <div class="search-box">
            <form method="get" class="search-form">
                <input type="text" name="busca" placeholder="Buscar nome ou CPF" value="<?= htmlspecialchars($busca) ?>">
                <button type="submit">🔍 Pesquisar</button>
            </form>
        </div>

        <?php if (count($alunos) > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Plano</th>
                            <th>Mensalidade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= protego($aluno['nome']) ?></td>
                            <td><?= protego($aluno['cpf']) ?></td>
                            <td><?= protego($aluno['email']) ?></td>
                            <td><?= protego($aluno['plano']) ?></td>
                            <td>R$ <?= number_format($aluno['mensalidade'], 2, ',', '.') ?></td>
                            <td>
                                <span class="status <?= $aluno['status'] == 1 ? 'status-ativo' : 'status-inativo' ?>">
                                    <?= $aluno['status'] == 1 ? 'Ativo' : 'Inativo' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="treino.php?id=<?= $aluno['id'] ?>" class="btn-action btn-treino">📋 Montar Treino</a>
                                    <a href="ver_treino.php?aluno_id=<?= $aluno['id'] ?>" class="btn-action btn-view">👁️ Ver treino</a>
                                    <a href="alterar/aluno.php?id=<?= $aluno['id'] ?>" class="btn-action btn-edit">✏️ Alterar</a>
                                    <a href="excluir/aluno.php?id=<?= $aluno['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">🗑️ Excluir</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Nenhum aluno encontrado.</p>
            </div>
        <?php endif; ?>

        <div class="consulta-footer">
            <a href="../home.php" class="btn-secondary">← Voltar</a>
        </div>
    </div>
</body>
</html>