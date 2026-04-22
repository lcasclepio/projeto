<?php
session_name('TREINO_ALUNO');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['aluno_id'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TreinoFit</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>TreinoFit</h1>
        </div>
        
        <form action="autenticar.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit">Entrar</button>
            <a href="./confirmar_cpf.php" class="forgot-password-btn" style="display:block; margin-top:10px; padding:10px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none; text-align:center;">
                Esqueci a Senha
            </a>
            <a href="./cadastro_aluno.php" class="register-btn" style="display:block; margin-top:10px; padding:10px; background:#28a745; color:#fff; border-radius:4px; text-decoration:none; text-align:center;">
                Cadastrar
            </a>
        </form>
    </div>
</body>
</html>
