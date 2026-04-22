<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";
require "../authentic/protego.php";

$idAluno = $_GET['id'] ?? null;

if (!$idAluno) {
    die("Aluno não informado");
}

$buscaAluno = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$buscaAluno->execute([$idAluno]);
$aluno = $buscaAluno->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Aluno não encontrado");
}

$pegarExercicios = $pdo->query("SELECT id, nome FROM exercicios ORDER BY nome");
$exercicios = $pegarExercicios->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacaoGeral = $_POST['observacao_geral'] ?? '';
    $listaExercicios = $_POST['exercicios'] ?? [];
    $comentarios = $_POST['comentario'] ?? [];

    $salvaTreino = $pdo->prepare(
        "INSERT INTO treinos (aluno_id, funcionario_id, observacao_geral, data_treino)
         VALUES (?, ?, ?, NOW())"
    );

    $salvaTreino->execute([
        $idAluno,
        $_SESSION['funcionario_id'],
        $observacaoGeral
    ]);

    $treinoId = $pdo->lastInsertId();

    $salvaItens = $pdo->prepare(
        "INSERT INTO treino_exercicios (treino_id, exercicio_id, comentario)
         VALUES (?, ?, ?)"
    );

    foreach ($listaExercicios as $exId) {
        $coment = $comentarios[$exId] ?? null;
        $salvaItens->execute([$treinoId, $exId, $coment]);
    }

    header("Location: treino.php?id=$idAluno&sucesso=1");
    exit;
} 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Treino</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Ficha de Treino</h1>
            <p>Monte o treino para o aluno</p>
        </div>

        <div class="aluno-info-card">
            <h3>Informações do Aluno</h3>
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

        <form method="post" class="form-content">
            <h2>Selecione os Exercícios</h2>
            <p class="form-subtitle">Escolha os exercícios e adicione comentários se necessário</p>

            <div class="exercicios-list">
                <?php foreach ($exercicios as $ex): ?>
                    <div class="exercicio-item">
                        <div class="exercicio-checkbox">
                            <label class="checkbox-label">
                                <input type="checkbox" name="exercicios[]" value="<?= $ex['id'] ?>">
                                <span><?= protego($ex['nome']) ?></span>
                            </label>
                        </div>
                        <input type="text" name="comentario[<?= $ex['id'] ?>]" placeholder="Adicionar comentário..." class="exercicio-comment">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="form-group">
                <label for="observacao_geral">Observação Geral</label>
                <textarea id="observacao_geral" name="observacao_geral" placeholder="Adicione observações gerais sobre o treino..." rows="5"></textarea>
            </div>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success">
                    ✓ Treino montado com sucesso!
                </div>
            <?php endif; ?>

            <div class="form-actions" id="form-actions">
                <button type="submit" class="btn-primary" onclick="return confirm('Tem certeza que deseja salvar o treino?');">💾 Salvar Treino</button>
                <a href="consulta_aluno.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        if (new URLSearchParams(window.location.search).has('sucesso')) {
            document.getElementById('form-actions').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
