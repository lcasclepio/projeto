<?php
require "../../banco/conexao.php";
require "../../authentic/verifica_login.php";
require "../../authentic/protego.php";

$idTreino = $_GET['id'] ?? null;

if (!$idTreino) {
    die("Treino não informado");
}

$buscaTreino = $pdo->prepare("SELECT * FROM treinos WHERE id = ?");
$buscaTreino->execute([$idTreino]);
$treino = $buscaTreino->fetch(PDO::FETCH_ASSOC);

if (!$treino) {
    die("Treino não encontrado");
}

$buscaAluno = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$buscaAluno->execute([$treino['aluno_id']]);
$aluno = $buscaAluno->fetch(PDO::FETCH_ASSOC);

$exercicios = $pdo->query("SELECT id, nome FROM exercicios ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$marcados = $pdo->prepare("SELECT exercicio_id, comentario FROM treino_exercicios WHERE treino_id = ?");
$marcados->execute([$idTreino]);
$mapa = [];

foreach ($marcados as $m) {
    $mapa[$m['exercicio_id']] = $m['comentario'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare(
        "UPDATE treinos SET observacao_geral = ? WHERE id = ?"
    )->execute([
        $_POST['observacao_geral'] ?? '',
        $idTreino
    ]);

    $pdo->prepare(
        "DELETE FROM treino_exercicios WHERE treino_id = ?"
    )->execute([$idTreino]);

    $salva = $pdo->prepare(
        "INSERT INTO treino_exercicios (treino_id, exercicio_id, comentario)
         VALUES (?, ?, ?)"
    );

    foreach ($_POST['exercicios'] ?? [] as $exId) {
        $coment = $_POST['comentario'][$exId] ?? null;
        $salva->execute([$idTreino, $exId, $coment]);
    }

    header("Location: treino.php?id=$idTreino&sucesso=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Treino</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="consulta-container">
        <div class="consulta-header">
            <h1>Alterar Treino</h1>
            <p>Atualize os exercícios e observações do treino</p>
        </div>

        <div class="aluno-info-card">
            <strong>🏃 Aluno:</strong> <?= protego($aluno['nome']) ?>
        </div>

        <div class="form-container">
            <form method="post" class="form-group">
                <h3 style="margin-top: 20px; margin-bottom: 15px; color: #333;">Exercícios</h3>

                <div class="exercicios-list">
                    <?php foreach ($exercicios as $ex): ?>
                    <div class="exercicio-item">
                        <div class="exercicio-checkbox">
                            <label>
                                <input
                                    type="checkbox"
                                    name="exercicios[]"
                                    value="<?= $ex['id'] ?>"
                                    <?= array_key_exists($ex['id'], $mapa) ? 'checked' : '' ?>
                                >
                                <span><?= protego($ex['nome']) ?></span>
                            </label>
                        </div>

                        <input
                            type="text"
                            name="comentario[<?= $ex['id'] ?>]"
                            value="<?= htmlspecialchars($mapa[$ex['id']] ?? '') ?>"
                            placeholder="💬 Comentário (séries, repetições, carga, etc)"
                            class="exercicio-comentario"
                        >
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-field" style="margin-top: 30px;">
                    <label for="observacao_geral">Observação Geral</label>
                    <textarea 
                        id="observacao_geral"
                        name="observacao_geral" 
                        placeholder="Adicione observações importantes sobre o treino..."
                    ><?= htmlspecialchars($treino['observacao_geral']) ?></textarea>
                </div>

                <?php if (isset($_GET['sucesso'])): ?>
                    <div class="alert alert-success">
                        ✓ Treino alterado com sucesso!
                    </div>
                <?php endif; ?>

                <div class="form-actions" id="form-actions">
                    <button type="submit" class="btn-primary" onclick="return confirm('Tem certeza que deseja alterar?');">💾 Salvar Alterações</button>
                    <a href="../ver_treino.php?aluno_id=<?= $treino['aluno_id'] ?>" class="btn-secondary">← Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        if (new URLSearchParams(window.location.search).has('sucesso')) {
            document.getElementById('form-actions').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
