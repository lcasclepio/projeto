<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome      = $_POST["nome"] ?? '';
    $sobrenome = $_POST["sobrenome"] ?? '';
    $email     = $_POST["email"] ?? '';
    $cargo     = $_POST["cargo"] ?? '';
    $cpf       = $_POST["cpf"] ?? '';
    $senha     = $_POST["senha"] ?? '';

    if (empty($nome) || empty($sobrenome) || empty($email) || empty($cargo) || empty($cpf) || empty($senha)) {
        header("Location: cadastro_funcionario.php?erro=1");
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $cadastro_fun = $pdo->prepare("INSERT INTO funcionarios (nome, sobrenome, email, cargo, cpf, senha) VALUES (?, ?, ?, ?, ?, ?)");
        $cadastro_fun->execute([$nome, $sobrenome, $email, $cargo, $cpf, $senhaHash]);
        
        header("Location: cadastro_Funcionario.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        header("Location: cadastro_Funcionario.php?erro=duplicado");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Cadastro de Funcionário</h1>
            <p>Preencha os dados do novo funcionário</p>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">
                ✓ Funcionário cadastrado com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-error">
                ✗ <?= $_GET['erro'] == 'duplicado' ? 'E-mail já está cadastrado.' : 'Erro ao cadastrar. Verifique os dados.' ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="form-content">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" placeholder="Nome do funcionário" required>
            </div>

            <div class="form-group">
                <label for="sobrenome">Sobrenome *</label>
                <input type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" placeholder="email@exemplo.com" required>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo *</label>
                <input type="text" id="cargo" name="cargo" placeholder="ex: Personal Trainer, Gerente" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF *</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha *</label>
                <input type="password" id="senha" name="senha" placeholder="Digite uma senha segura" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Cadastrar Funcionário</button>
                <a href="../home.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>