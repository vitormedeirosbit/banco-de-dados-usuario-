<?php

require_once "../config/protecao.php";
require_once "../config/conexao.php";

exigirNivel("administrador");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$nome = trim($_POST["nome"] ?? "");
$usuario = trim($_POST["usuario"] ?? "");
$email = trim($_POST["email"] ?? "");
$nivel_acesso = $_POST["nivel_acesso"] ?? "";
$status = $_POST["status"] ?? "";


/*
|--------------------------------------------------------------------------
| Validar ID
|--------------------------------------------------------------------------
*/

if (!$id) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Validar campos
|--------------------------------------------------------------------------
*/

if (
    $nome === "" ||
    $usuario === "" ||
    $email === "" ||
    $nivel_acesso === "" ||
    $status === ""
) {
    die("Todos os campos são obrigatórios.");
}


/*
|--------------------------------------------------------------------------
| Validar e-mail
|--------------------------------------------------------------------------
*/

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}


/*
|--------------------------------------------------------------------------
| Validar nível de acesso
|--------------------------------------------------------------------------
*/

if (!in_array($nivel_acesso, ["administrador", "operador"])) {
    die("Nível de acesso inválido.");
}


/*
|--------------------------------------------------------------------------
| Validar status
|--------------------------------------------------------------------------
*/

if (!in_array($status, ["ativo", "inativo"])) {
    die("Status inválido.");
}


/*
|--------------------------------------------------------------------------
| Verificar duplicidade
|--------------------------------------------------------------------------
|
| O usuário/e-mail pode pertencer ao próprio registro.
| Por isso usamos "id != ?".
|
*/

$sql = "SELECT id
        FROM usuarios
        WHERE (usuario = ? OR email = ?)
        AND id != ?
        LIMIT 1";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssi",
    $usuario,
    $email,
    $id
);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $stmt->close();
    $conexao->close();

    header("Location: editar.php?id=" . $id . "&erro=duplicado");
    exit;
}

$stmt->close();


/*
|--------------------------------------------------------------------------
| Atualizar usuário
|--------------------------------------------------------------------------
*/

$sql = "UPDATE usuarios
        SET nome = ?,
            usuario = ?,
            email = ?,
            nivel_acesso = ?,
            status = ?
        WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "sssssi",
    $nome,
    $usuario,
    $email,
    $nivel_acesso,
    $status,
    $id
);

$stmt->execute();

$stmt->close();
$conexao->close();


/*
|--------------------------------------------------------------------------
| Voltar para a lista
|--------------------------------------------------------------------------
*/

header("Location: index.php?sucesso=atualizado");
exit;

?>