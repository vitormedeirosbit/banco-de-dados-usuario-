<?php

require_once "config/protecao.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Controle de Estoque</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f2f4f7;
        }

        header {
            background: #222;
            color: white;
            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 22px;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout {
            background: #c62828;
            color: white;
            text-decoration: none;

            padding: 8px 14px;
            border-radius: 5px;
        }

        main {
            padding: 30px;
        }

        .boas-vindas {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .boas-vindas h2 {
            margin-bottom: 10px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            margin-bottom: 10px;
        }

    </style>

</head>

<body>

<header>

    <h1>Sistema de Controle de Estoque</h1>

    <div class="usuario">

        <span>
            Olá, <?php echo htmlspecialchars($_SESSION["nome"]); ?>
        </span>

        <a href="logout.php" class="logout">
            Sair
        </a>

    </div>

</header>

<main>

    <section class="boas-vindas">

        <h2>Bem-vindo ao sistema!</h2>

        <p>
            Você está conectado como
            <strong>
                <?php echo htmlspecialchars($_SESSION["nivel_acesso"]); ?>
            </strong>.
        </p>

    </section>

    <section class="cards">

        <div class="card">
            <h3>Produtos</h3>
            <p>0 produtos cadastrados</p>
        </div>

        <div class="card">
            <h3>Estoque</h3>
            <p>Consulta de estoque</p>
        </div>

        <div class="card">
            <h3>Entradas</h3>
            <p>Registro de entradas</p>
        </div>

        <div class="card">
            <h3>Saídas</h3>
            <p>Registro de saídas</p>
        </div>

    </section>

</main>

</body>

</html>