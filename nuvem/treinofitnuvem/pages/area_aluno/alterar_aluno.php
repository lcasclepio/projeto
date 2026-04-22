<?php
require "../../banco/conexao.php";
require "../../authentic/protego.php";
require "verifica.php";

$alunoId = $_SESSION['aluno_id'];

$buscaAluno = $pdo->prepare("
    SELECT nome, email
    FROM alunos
    WHERE id = ?
");
$buscaAluno->execute([$alunoId]);
$aluno = $buscaAluno->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $update = $pdo->prepare("
            UPDATE alunos
            SET nome = ?, email = ?, senha = ?
            WHERE id = ?
        ");
        $update->execute([$nome, $email, $senhaHash, $alunoId]);

    } else {

        $update = $pdo->prepare("
            UPDATE alunos
            SET nome = ?, email = ?
            WHERE id = ?
        ");
        $update->execute([$nome, $email, $alunoId]);
    }

    header("Location: perfil_aluno.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Dados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h1>Alterar Meus Dados</h1>

        <form method="POST">

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" required value="<?= protego($aluno['nome']) ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required value="<?= protego($aluno['email']) ?>">
            </div>

            <div class="form-group">
                <label>Nova Senha</label>
                <input type="password" name="senha" placeholder="Deixe em branco para manter a senha atual">
            </div>

            <div class="form-actions">
                <a href="perfil_aluno.php" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar Alterações</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
