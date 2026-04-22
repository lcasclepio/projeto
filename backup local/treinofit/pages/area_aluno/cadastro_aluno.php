<?php
require "../../banco/conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome  = $_POST["nome"] ?? '';
    $cpf   = $_POST["cpf"] ?? '';
    $email = $_POST["email"] ?? '';
    $senha = $_POST["senha"] ?? '';

    if (empty($nome) || empty($cpf) || empty($email) || empty($senha)) {
        header("Location: cadastro_aluno.php?erro=vazio");
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $cadastro = $pdo->prepare(
            "INSERT INTO alunos (nome, cpf, email, senha)
             VALUES (?, ?, ?, ?)"
        );

        $cadastro->execute([$nome, $cpf, $email, $senhaHash]);

        header("Location: cadastro_aluno.php?sucesso=1");
        exit;

    } catch (PDOException $e) {
        header("Location: cadastro_aluno.php?erro=duplicado");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Pré-Cadastro</h1>
            <p>Crie sua conta para acessar o sistema</p>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">
                Cadastro realizado com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-error">
                <?= $_GET['erro'] == 'duplicado' ? 'CPF ou E-mail já cadastrados.' : 'Preencha todos os campos obrigatórios.' ?>
            </div>
        <?php endif; ?>

        <form method="post" class="form-content">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Criar Conta</button>
                <a href="login.php" class="btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
