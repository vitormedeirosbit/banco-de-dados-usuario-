<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Controle de Estoque</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f2f4f7;
        }

        .login-container {
            width: 400px;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .login-container p {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        .campo input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
        }

        .campo input:focus {
            border-color: #333;
        }

        .botao {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #222;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .botao:hover {
            background: #333;
        }

        .erro {
            background: #ffe5e5;
            color: #c62828;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h1>Controle de Estoque</h1>

        <p>Acesse sua conta</p>

        <?php if (isset($_GET['erro'])): ?>

            <div class="erro">
                Usuário/e-mail ou senha incorretos.
            </div>

        <?php endif; ?>

        <form action="autenticar.php" method="POST">

            <div class="campo">
                <label for="login">Usuário ou e-mail</label>

                <input
                    type="text"
                    id="login"
                    name="login"
                    placeholder="Digite seu usuário ou e-mail"
                    required
                >
            </div>

            <div class="campo">
                <label for="senha">Senha</label>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Digite sua senha"
                    required
                >
            </div>

            <button type="submit" class="botao">
                Entrar
            </button>

        </form>

    </div>

</body>
</html>