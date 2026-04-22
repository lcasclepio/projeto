<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TreinoFit</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>TreinoFit</h1>
            <h2>Página do funcionário</h2>
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
            <a href="pages/area_aluno/login.php" class="student-btn" style="display:block; margin-top:15px; padding:10px; background:#007bff; color:#fff; border-radius:4px; text-decoration:none; text-align:center;">Ir para página do aluno →</a>
        </form>
    </div>
</body>
</html>
