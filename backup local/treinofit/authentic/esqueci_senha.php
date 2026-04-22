<?php
require "../banco/conexao.php";

$etapa = 1;
$aluno = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        $stmt = $pdo->prepare("SELECT id FROM alunos WHERE cpf = ?");
        $stmt->execute([$cpf]);
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aluno) {
            $etapa = 2;
        } else {
            $erro = "CPF não encontrado";
        }
    }

    if (isset($_POST['nova_senha'], $_POST['aluno_id'])) {
        $senhaHash = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

        $pdo->prepare(
            "UPDATE alunos SET senha = ? WHERE id = ?"
        )->execute([$senhaHash, $_POST['aluno_id']]);

        $sucesso = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/css/estilo.css">
</head>
<body>
<div class="container">

<?php if (!empty($sucesso)): ?>
    <p>Senha alterada com sucesso</p>
    <a href="/login.php">Voltar ao login</a>

<?php elseif ($etapa === 1): ?>
    <form method="post">
        <input name="cpf" placeholder="Digite seu CPF" required>
        <button>Continuar</button>
        <?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
    </form>

<?php elseif ($etapa === 2): ?>
    <form method="post">
        <input type="hidden" name="aluno_id" value="<?= $aluno['id'] ?>">
        <input type="password" name="nova_senha" placeholder="Nova senha" required>
        <button>Alterar senha</button>
    </form>
<?php endif; ?>

</div>
</body>
</html>
