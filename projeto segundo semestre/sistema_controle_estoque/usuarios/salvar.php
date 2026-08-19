<?php

require_once "../config/protecao.php";
require_once "../config/conexao.php";

exigirNivel("administrador");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$usuario = trim($_POST["usuario"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";
$nivel_acesso = $_POST["nivel_acesso"] ?? "";

/*
|--------------------------------------------------------------------------
| Validação dos campos
|--------------------------------------------------------------------------
*/

if (
    $nome === "" ||
    $usuario === "" ||
    $email === "" ||
    $senha === "" ||
    $nivel_acesso === ""
) {
    header("Location: cadastrar.php?erro=campos");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: cadastrar.php?erro=email");
    exit;
}

if (strlen($senha) < 6) {
    header("Location: cadastrar.php?erro=senha");
    exit;
}

if (!in_array($nivel_acesso, ["administrador", "operador"])) {
    header("Location: cadastrar.php?erro=nivel");
    exit;
}

/*
|--------------------------------------------------------------------------
| Verificar se usuário ou e-mail já existem
|--------------------------------------------------------------------------
*/

$sql = "SELECT id
        FROM usuarios
        WHERE usuario = ? OR email = ?
        LIMIT 1";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ss",
    $usuario,
    $email
);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $stmt->close();
    $conexao->close();

    header("Location: cadastrar.php?erro=duplicado");
    exit;
}

$stmt->close();

/*
|--------------------------------------------------------------------------
| Criar hash da senha
|--------------------------------------------------------------------------
*/

$senha_hash = password_hash(
    $senha,
    PASSWORD_DEFAULT
);

/*
|--------------------------------------------------------------------------
| Inserir usuário
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO usuarios
        (nome, usuario, email, senha, nivel_acesso)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "sssss",
    $nome,
    $usuario,
    $email,
    $senha_hash,
    $nivel_acesso
);

$stmt->execute();

$stmt->close();
$conexao->close();

header("Location: index.php?sucesso=cadastrado");
exit;

?>