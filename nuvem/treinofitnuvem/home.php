<?php
require "authentic/verifica_login.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Central TreinoFit</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="dashboard-container">
            <header class="dashboard-header">
                <h1>Central TreinoFit</h1>
                <form action="logout.php" method="post" class="logout-form">
                    <button type="submit" class="btn-logout">Sair</button>
                </form>
            </header>

            <main class="dashboard-main">
                <section class="section">
                    <h2>👥 Alunos</h2>
                    <div class="cards-grid">
                        <div class="card">
                            <h3>Cadastro de aluno</h3>
                            <p>Registre novos alunos no sistema</p>
                            <a href="pages/cadastro_aluno.php" class="btn-primary">Cadastrar aluno</a>
                        </div>

                        <div class="card">
                            <h3>Consulta de aluno</h3>
                            <p>Visualize dados dos alunos cadastrados</p>
                            <a href="pages/consulta_aluno.php" class="btn-primary">Consultar aluno</a>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <h2>👔 Funcionários</h2>
                    <div class="cards-grid">
                        <div class="card">
                            <h3>Cadastro de funcionário</h3>
                            <p>Registre novos funcionários no sistema</p>
                            <a href="pages/cadastro_Funcionario.php" class="btn-primary">Cadastrar funcionário</a>
                        </div>

                        <div class="card">
                            <h3>Consulta de funcionário</h3>
                            <p>Visualize dados dos funcionários cadastrados</p>
                            <a href="pages/consulta_funcionario.php" class="btn-primary">Consultar funcionário</a>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>