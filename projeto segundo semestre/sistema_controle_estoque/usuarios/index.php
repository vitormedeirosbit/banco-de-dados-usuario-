<?php

require_once "../config/protecao.php";
require_once "../config/conexao.php";

exigirNivel("administrador");

$sucesso = $_GET["sucesso"] ?? "";

$sql = "SELECT id, nome, usuario, email, nivel_acesso, status, data_cadastro
        FROM usuarios
        ORDER BY id DESC";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Usuários - Controle de Estoque</title>

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

        .voltar {
            color: white;
            text-decoration: none;
        }

        main {
            padding: 30px;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;
        }

        .topo h2 {
            color: #222;
        }

        .botao {
            background: #222;
            color: white;

            padding: 10px 16px;

            text-decoration: none;

            border-radius: 6px;
        }

        .tabela-container {
            background: white;

            padding: 20px;

            border-radius: 10px;

            overflow-x: auto;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;

            text-align: left;

            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
        }

        .ativo {
            color: green;
            font-weight: bold;
        }

        .inativo {
            color: red;
            font-weight: bold;
        }

        .administrador {
            font-weight: bold;
        }

        .mensagem {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.sucesso {
    background: #e5f6e9;
    color: #2e7d32;
}

    </style>

</head>

<body>

<header>

    <h1>Controle de Estoque</h1>

    <a href="../dashboard.php" class="voltar">
        ← Dashboard
    </a>

</header>

<main> 

<?php if ($sucesso === "atualizado"): ?>

    <div class="mensagem sucesso">
        Usuário atualizado com sucesso!
    </div>

<?php endif; ?>

<?php if ($sucesso === "cadastrado"): ?>

    <div class="mensagem sucesso">
        Usuário cadastrado com sucesso!
    </div>

<?php endif; ?>

    <div class="topo">

        <h2>Usuários</h2>

        <a href="cadastrar.php" class="botao">
            + Novo usuário
        </a>

    </div>

    <div class="tabela-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Nível de acesso</th>
                    <th>Status</th>
                    <th>Data de cadastro</th>
                    <th>Ações</th>

                </tr>

            </thead>

            <tbody>

                <?php if ($resultado->num_rows > 0): ?>

                    <?php while ($usuario = $resultado->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo $usuario["id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($usuario["nome"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($usuario["usuario"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($usuario["email"]); ?>
                            </td>

                            <td class="<?php echo $usuario["nivel_acesso"]; ?>">

                                <?php

                                echo $usuario["nivel_acesso"] === "administrador"
                                    ? "Administrador"
                                    : "Operador";

                                ?>

                            </td>

                            <td>

                                <?php if ($usuario["status"] === "ativo"): ?>

                                    <span class="ativo">
                                        Ativo
                                    </span>

                                <?php else: ?>

                                    <span class="inativo">
                                        Inativo
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php

                                echo date(
                                    "d/m/Y H:i",
                                    strtotime($usuario["data_cadastro"])
                                );

                                ?>

                            </td>

                            <td>

    <a href="editar.php?id=<?php echo $usuario["id"]; ?>">
        Editar
    </a>

</td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7">
                            Nenhum usuário cadastrado.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</main>

</body>

</html>