<?php
require "verifica.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Aluno - TreinoFit</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Área do Aluno</h1>
            <form action="logout.php" method="post" class="logout-form">
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </header>

        <main class="dashboard-main">
            <section class="section">
                <h2>Minha Conta</h2>
                <div class="cards-grid">
                    <div class="card">
                        <h3>Meu Perfil</h3>
                        <p>Visualize e altere seus dados pessoais</p>
                        <a href="perfil_aluno.php" class="btn-primary">
                            Ver Perfil
                        </a>
                    </div>

                    <div class="card">
                        <h3>Meu Treino</h3>
                        <p>Visualize seu treino atual</p>
                        <a href="ver_treino.php" class="btn-primary">
                            Ver Treino
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
