<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Função para verificar se o usuário está logado
function esta_logado() {
    return isset($_SESSION['usuario_id']);
}

// Redirecionar para login se não estiver logado
function exigir_login() {
    if (!esta_logado()) {
        header("Location: index.php?page=login");
        exit;
    }
}

// Função para obter o nome do usuário (opcional)
function usuario_nome() {
    return $_SESSION['usuario_nome'] ?? 'Usuário';
}
