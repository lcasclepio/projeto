<?php
session_name('TREINO_ALUNO');
session_start();
require "../../banco/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - TreinoFit</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Recuperar Senha</h1>
        </div>
        
        <form method="POST" action="processa_confirmacao.php">

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
            </div>

            <button type="submit">Confirmar</button>
            <a href="./login.php" class="register-btn" style="display:block; margin-top:10px; padding:10px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none; text-align:center;">
                Voltar ao Login
            </a>
        </form>
    </div>
</body>
</html>
