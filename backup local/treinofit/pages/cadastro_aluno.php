<?php
require "../banco/conexao.php";
require "../authentic/verifica_login.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome        = $_POST["nome"] ?? '';
    $cpf         = $_POST["cpf"] ?? '';
    $email       = $_POST["email"] ?? '';
    $senha       = $_POST["senha"] ?? '';
    $plano       = $_POST["plano"] ?? '';
    $mensalidade = $_POST["mensalidade"] ?? '';
    $status      = $_POST["status"] ?? '';
    $observacoes = $_POST["observacoes"] ?? '';

    if (empty($nome) || empty($cpf) || empty($email) || empty($senha) || empty($plano) || empty($mensalidade)) {
        header("Location: cadastro_aluno.php?erro=vazio");
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $cadastro = $pdo->prepare(
            "INSERT INTO alunos 
            (nome, cpf, email, senha, plano, mensalidade, status, observacoes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
        
            $cadastro->execute([$nome, $cpf, $email, $senhaHash, $plano, $mensalidade, $status, $observacoes]);
        
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
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Cadastro de Aluno</h1>
            <p>Preencha os dados do novo aluno</p>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">
                ✓ Aluno cadastrado com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-error">
                ✗ <?= $_GET['erro'] == 'duplicado' ? 'CPF ou E-mail já cadastrados.' : 'Preencha todos os campos obrigatórios.' ?>
            </div>
        <?php endif; ?>

        <form method="post" class="form-content">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" placeholder="Nome completo" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cpf">CPF *</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" placeholder="email@exemplo.com" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="senha">Senha *</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite uma senha segura" required>
                </div>

                <div class="form-group">
                    <label for="plano">Plano *</label>
                    <select id="plano" name="plano" required>
                        <option value="">Selecione um plano</option>
                        <option value="Básico">Básico</option>
                        <option value="Premium">Premium</option>
                        <option value="VIP">VIP</option>
                        <option value="Personalizado">Personalizado</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mensalidade">Mensalidade (R$) *</label>
                    <input type="number" id="mensalidade" name="mensalidade" step="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes" placeholder="Adicione observações se necessário" rows="4"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Cadastrar Aluno</button>
                <a href="../home.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>