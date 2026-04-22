<?php
session_name('TREINO_ALUNO');
session_start();

if (!isset($_SESSION['reset_aluno_id'])) {
    header("Location: login.php");
    exit;
}

$sucesso = isset($_GET['sucesso']) && $_GET['sucesso'] == 1;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha - TreinoFit</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
    <?php if ($sucesso): ?>
        <meta http-equiv="refresh" content="3;url=login.php">
    <?php endif; ?>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Nova Senha</h1>
        </div>
        
        <?php if ($sucesso): ?>
            <div style="background-color:#d4edda; color:#155724; padding:12px; border-radius:4px; margin-bottom:20px; text-align:center; font-size:14px; border:1px solid #c3e6cb;">
                ✓ Senha alterada com sucesso!
            </div>
        <?php endif; ?>
        <form method="POST" action="processa_nova_senha.php">

            <div class="form-group">
                <label for="senha">Nova Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua nova senha" required>
            </div>

            <div class="form-group">
                <label for="confirmar">Confirmar Senha</label>
                <input type="password" id="confirmar" name="confirmar" placeholder="Confirme sua nova senha" required>
            </div>

            <button type="submit">Alterar Senha</button>
            <a href="./login.php" class="register-btn" style="display:block; margin-top:10px; padding:10px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none; text-align:center;">
                Voltar ao Login
            </a>
        </form>
    </div>
</body>
</html>
