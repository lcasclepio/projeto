<?php
require "../../banco/conexao.php";
require "../../authentic/protego.php";
require "verifica.php";

$alunoId = $_SESSION['aluno_id'];

$buscaAluno = $pdo->prepare("SELECT nome, plano, status FROM alunos WHERE id = ?");
$buscaAluno->execute([$alunoId]);
$aluno = $buscaAluno->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit;
}

$buscaTreino = $pdo->prepare("
    SELECT *
    FROM treinos
    WHERE aluno_id = ?
    ORDER BY data_treino DESC
");
$buscaTreino->execute([$alunoId]);
$treinos = $buscaTreino->fetchAll(PDO::FETCH_ASSOC);

if (empty($treinos)) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Treino</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
    <style>
        .no-treino-box { max-width:720px; margin:48px auto; text-align:center; }
        .no-treino-msg { font-size:18px; color:#7a8a99; margin-bottom:20px; }
        .no-treino-actions { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
    </style>
</head>
<body>
    <div class="no-treino-box">
        <div class="empty-state" style="padding:32px;">
            <p class="no-treino-msg">Você ainda não possui treino cadastrado.</p>
            <div class="no-treino-actions">
                <a href="home.php" class="btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Treino</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="treino-container">
        <div class="treino-header">
            <h1>Ficha de Treino</h1>
            <p>Visualize seu treino atual</p>
        </div>

        <div class="aluno-info-card">
            <h3>Minhas Informações</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nome</span>
                    <span class="info-value"><?= protego($aluno['nome']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Plano</span>
                    <span class="info-value"><?= protego($aluno['plano']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="status <?= $aluno['status'] == 1 ? 'status-ativo' : 'status-inativo' ?>">
                            <?= $aluno['status'] == 1 ? 'Ativo' : 'Inativo' ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="exercicios-card">
            <div class="exercicios-header">
                <h2>Treinos</h2>
            </div>
            <div class="exercicios-display">
                <?php foreach ($treinos as $index => $treino): ?>
                    <?php
                    $buscaEx = $pdo->prepare(
                        "SELECT e.nome, te.comentario
                         FROM treino_exercicios te
                         JOIN exercicios e ON e.id = te.exercicio_id
                         WHERE te.treino_id = ?"
                    );
                    $buscaEx->execute([$treino['id']]);
                    $exercicios = $buscaEx->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="treino-card">
                        <div class="treino-card-header">
                            <div class="treino-info">
                                <strong>Treino de <?= date('d/m/Y', strtotime($treino['data_treino'])) ?></strong>
                                <span class="treino-label"><?= $index === 0 ? 'Atual' : 'Anterior' ?></span>
                            </div>
                        </div>
                        <div class="treino-card-content">
                            <div class="exercicios-list">
                                <h4>Exercícios:</h4>
                                <?php if (empty($exercicios)): ?>
                                    <p class="no-exercises"><em>Sem exercícios</em></p>
                                <?php else: ?>
                                    <?php foreach ($exercicios as $item): ?>
                                        <div class="exercicio-item">
                                            <div class="exercicio-nome">
                                                <span class="exercicio-icon">💪</span>
                                                <strong><?= protego($item['nome']) ?></strong>
                                            </div>
                                            <div class="exercicio-obs">
                                                <?= $item['comentario'] ? protego($item['comentario']) : '<em>Sem observações</em>' ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="treino-observacao">
                                <h4>Observação Geral:</h4>
                                <p>
                                    <?= $treino['observacao_geral'] ? protego($treino['observacao_geral']) : '<em>Nenhuma observação</em>' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="treino-actions">
            <a href="home.php" class="btn-secondary">← Voltar</a>
        </div>
    </div>
</body>
</html>
