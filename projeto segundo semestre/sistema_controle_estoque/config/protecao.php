<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

function exigirNivel($nivelPermitido)
{
    if (!isset($_SESSION["nivel_acesso"])) {
        header("Location: ../login.php");
        exit;
    }

    if ($_SESSION["nivel_acesso"] !== $nivelPermitido) {
        http_response_code(403);

        echo "<h1>Acesso negado</h1>";
        echo "<p>Você não possui permissão para acessar esta página.</p>";
        echo '<a href="../dashboard.php">Voltar ao Dashboard</a>';

        exit;
    }
}