<?php
$page = $_GET['page'] ?? 'home';

// Caminho do conteúdo
$page_path = "pages/$page.php";

// Inclui cabeçalho
include 'includes/header.php';

// Verifica se a página existe
if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "ERROR 404 - PAGE NOT FOUND";
}

// Inclui rodapé
include 'includes/footer.php';
?>