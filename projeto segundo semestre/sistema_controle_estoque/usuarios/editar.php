<?php

require_once "../config/protecao.php";
require_once "../config/conexao.php";

exigirNivel("administrador");

$erro = $_GET["erro"] ?? "";
$sucesso = $_GET["sucesso"] ?? "";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

$sql = "SELECT id, nome, usuario, email, nivel_acesso, status
        FROM usuarios
        WHERE id = ?
        LIMIT 1";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    $stmt->close();
    $conexao->close();

    header("Location: index.php");
    exit;
}

$usuario = $resultado->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuário - Controle de Estoque</title>

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

        .form-container {
            max-width: 600px;
            margin: 0 auto;

            background: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .form-container h2 {
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;
        }

        .campo input,
        .campo select {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 15px;
        }

        .botoes {
            display: flex;

            gap: 10px;

            margin-top: 25px;
        }

        .botao {
            padding: 11px 18px;

            border: none;

            border-radius: 6px;

            cursor: pointer;

            text-decoration: none;

            font-size: 15px;
        }

        .salvar {
            background: #222;
            color: white;
        }

        .cancelar {
            background: #ddd;
            color: #222;
        }

        .mensagem {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.erro {
    background: #ffe5e5;
    color: #c62828;
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

    <a href="index.php" class="voltar">
        ← Usuários
    </a>

</header>

<main>

    <div class="form-container">

<?php if ($erro === "duplicado"): ?>

    <div class="mensagem erro">
        O usuário ou e-mail informado já está cadastrado para outro usuário.
    </div>

<?php endif; ?>

<?php if ($sucesso === "atualizado"): ?>

    <div class="mensagem sucesso">
        Usuário atualizado com sucesso!
    </div>

<?php endif; ?>

        <h2>Editar usuário</h2>

        <form action="atualizar.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?php echo $usuario["id"]; ?>"
            >

            <div class="campo">

                <label for="nome">
                    Nome completo
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="<?php echo htmlspecialchars($usuario["nome"]); ?>"
                    required
                >

            </div>

            <div class="campo">

                <label for="usuario">
                    Usuário
                </label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    value="<?php echo htmlspecialchars($usuario["usuario"]); ?>"
                    required
                >

            </div>

            <div class="campo">

                <label for="email">
                    E-mail
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($usuario["email"]); ?>"
                    required
                >

            </div>

            <div class="campo">

                <label for="nivel_acesso">
                    Nível de acesso
                </label>

                <select
                    id="nivel_acesso"
                    name="nivel_acesso"
                    required
                >

                    <option
                        value="administrador"
                        <?php echo $usuario["nivel_acesso"] === "administrador" ? "selected" : ""; ?>
                    >
                        Administrador
                    </option>

                    <option
                        value="operador"
                        <?php echo $usuario["nivel_acesso"] === "operador" ? "selected" : ""; ?>
                    >
                        Operador
                    </option>

                </select>

            </div>

            <div class="campo">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option
                        value="ativo"
                        <?php echo $usuario["status"] === "ativo" ? "selected" : ""; ?>
                    >
                        Ativo
                    </option>

                    <option
                        value="inativo"
                        <?php echo $usuario["status"] === "inativo" ? "selected" : ""; ?>
                    >
                        Inativo
                    </option>

                </select>

            </div>

            <div class="botoes">

                <button
                    type="submit"
                    class="botao salvar"
                >
                    Salvar alterações
                </button>

                <a
                    href="index.php"
                    class="botao cancelar"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</main>

</body>

</html>