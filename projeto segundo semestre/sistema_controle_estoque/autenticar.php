<?php

session_start();

require_once "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$login = trim($_POST["login"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($login === "" || $senha === "") {
    header("Location: login.php?erro=1");
    exit;
}

$sql = "SELECT id, nome, usuario, email, senha, nivel_acesso, status
        FROM usuarios
        WHERE usuario = ? OR email = ?
        LIMIT 1";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("ss", $login, $login);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: login.php?erro=1");
    exit;
}

$usuario = $resultado->fetch_assoc();

if ($usuario["status"] !== "ativo") {
    header("Location: login.php?erro=1");
    exit;
}

if (!password_verify($senha, $usuario["senha"])) {
    header("Location: login.php?erro=1");
    exit;
}

session_regenerate_id(true);

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["nome"] = $usuario["nome"];
$_SESSION["usuario"] = $usuario["usuario"];
$_SESSION["email"] = $usuario["email"];
$_SESSION["nivel_acesso"] = $usuario["nivel_acesso"];

$stmt->close();
$conexao->close();

header("Location: dashboard.php");
exit;

?>