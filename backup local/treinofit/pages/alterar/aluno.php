<?php
require "../../banco/conexao.php";
require "../../authentic/verifica_login.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$stmt->execute([$id]);
$aluno = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = $_POST['senha'] ?? '';

    $params = [
        $_POST['nome'],
        $_POST['cpf'],
        $_POST['email'],
        $_POST['plano'],
        $_POST['mensalidade'],
        $_POST['status'],
        $_POST['observacoes'],
    ];

    $sql = "UPDATE alunos SET nome=?, cpf=?, email=?, plano=?, mensalidade=?, status=?, observacoes=?";

    if (!empty($senha)) {
        $sql .= ", senha=?";
        $params[] = password_hash($senha, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id=?";
    $params[] = $id;

    $pdo->prepare($sql)->execute($params);

    header("Location: ../consulta_aluno.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Aluno</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="consulta-container">
        <div class="consulta-header">
            <h1>Alterar Aluno</h1>
            <p>Atualize as informações do aluno</p>
        </div>

        <div class="form-container">
            <form method="post" class="form-group">
                <div class="form-field">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($aluno['cpf']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($aluno['email']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="plano">Plano</label>
                    <select id="plano" name="plano" required>
                        <option value="">Selecione um plano</option>
                        <option value="Básico" <?= $aluno['plano'] === 'Básico' ? 'selected' : '' ?>>Básico</option>
                        <option value="Premium" <?= $aluno['plano'] === 'Premium' ? 'selected' : '' ?>>Premium</option>
                        <option value="VIP" <?= $aluno['plano'] === 'VIP' ? 'selected' : '' ?>>VIP</option>
                        <option value="Personalizado" <?= $aluno['plano'] === 'Personalizado' ? 'selected' : '' ?>>Personalizado</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="mensalidade">Mensalidade</label>
                    <input type="number" id="mensalidade" name="mensalidade" step="0.01" value="<?= htmlspecialchars($aluno['mensalidade']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="1" <?= $aluno['status'] ? 'selected' : '' ?>>Ativo</option>
                        <option value="0" <?= !$aluno['status'] ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" value="" placeholder="Deixe em branco para manter a senha atual">
                </div>

                <div class="form-field">
                    <label for="observacoes">Observações</label>
                    <textarea id="observacoes" name="observacoes"><?= htmlspecialchars($aluno['observacoes']) ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" onclick="return confirm('Tem certeza que deseja alterar?');">💾 Salvar</button>
                    <a href="../consulta_aluno.php" class="btn-secondary">← Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
