<?php
require "../../banco/conexao.php";
require "../../authentic/verifica_login.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Funcionário não informado");
}

$stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
$stmt->execute([$id]);
$func = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$func) {
    die("Funcionário não encontrado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $email = $_POST['email'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($senha !== '') {
        // atualizar incluindo a nova senha (hashed)
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $pdo->prepare(
            "UPDATE funcionarios 
             SET nome = ?, sobrenome = ?, cpf = ?, email = ?, cargo = ?, senha = ?
             WHERE id = ?"
        )->execute([$nome, $sobrenome, $cpf, $email, $cargo, $senha_hash, $id]);
    } else {
        // atualizar sem alterar a senha
        $pdo->prepare(
            "UPDATE funcionarios 
             SET nome = ?, sobrenome = ?, cpf = ?, email = ?, cargo = ?
             WHERE id = ?"
        )->execute([$nome, $sobrenome, $cpf, $email, $cargo, $id]);
    }

    header("Location: ../consulta_funcionario.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Funcionário</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="consulta-container">
        <div class="consulta-header">
            <h1>Alterar Funcionário</h1>
            <p>Atualize as informações do funcionário</p>
        </div>

        <div class="form-container">
            <form method="post" class="form-group">
                <div class="form-field">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($func['nome']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" id="sobrenome" name="sobrenome" value="<?= htmlspecialchars($func['sobrenome']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($func['cpf']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($func['email']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="cargo">Cargo</label>
                    <input type="text" id="cargo" name="cargo" value="<?= htmlspecialchars($func['cargo']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" value="" placeholder="Deixe em branco para manter a senha atual">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" onclick="return confirm('Tem certeza que deseja alterar?');">💾 Salvar</button>
                    <a href="../consulta_funcionario.php" class="btn-secondary">← Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
