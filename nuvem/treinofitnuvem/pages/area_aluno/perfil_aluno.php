<?php
require "../../banco/conexao.php";
require "../../authentic/protego.php";
require "verifica.php";

$idAluno = $_SESSION['aluno_id'];

$sqlAluno = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$sqlAluno->execute([$idAluno]);
$aluno = $sqlAluno->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="perfil-container">
        <div class="perfil-header">
            <h1>Meu Perfil</h1>
            <p>Se algum campo estiver fazio você deve finalizar presencialmente na academia</p>
        </div>

        <div class="perfil-card">
            <div class="perfil-info">

                <div class="info-group">
                    <label>Nome</label>
                    <p><?= protego($aluno['nome']) ?></p>
                </div>

                <div class="info-group">
                    <label>CPF</label>
                    <p><?= protego($aluno['cpf']) ?></p>
                </div>

                <div class="info-group">
                    <label>Email</label>
                    <p><?= protego($aluno['email']) ?></p>
                </div>

                <div class="info-group">
                    <label>Plano</label>
                    <p><?= protego($aluno['plano']) ?></p>
                </div>

                <div class="info-group">
                    <label>Mensalidade</label>
                    <p>R$ <?= number_format($aluno['mensalidade'], 2, ',', '.') ?></p>
                </div>

                <div class="info-group">
                    <label>Status</label>
                    <p><?= $aluno['status'] == 1 ? 'Ativo' : 'Inativo' ?></p>
                </div>

                <div class="info-group">
                    <label>Observações</label>
                    <p>
                        <?= $aluno['observacoes'] ? protego($aluno['observacoes']) : 'Nenhuma observação' ?>
                    </p>
                </div>

            </div>
        </div>

        <div class="perfil-actions">
            <a href="home.php" class="btn-secondary">← Voltar</a>
            <a href="alterar_aluno.php" class="btn-primary">Editar Dados Básicos</a>
        </div>
    </div>
</body>
</html>
