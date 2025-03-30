<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!esta_logado()) {
    header("Location: ../index.php?page=login");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$produto_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($produto_id <= 0) {
    http_response_code(400);
    echo "Produto inválido.";
    exit;
}

// Verifica se o produto pertence ao usuário
$stmt = $conn->prepare("SELECT * FROM usuarios_produtos WHERE usuario_id = ? AND produto_id = ?");
$stmt->bind_param("ii", $usuario_id, $produto_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    http_response_code(403);
    echo "Você não tem permissão para baixar este arquivo.";
    exit;
}

// Busca o arquivo STL no banco
$stmt = $conn->prepare("SELECT nome_arquivo, tipo_mime, conteudo FROM arquivos_stl WHERE produto_id = ?");
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    http_response_code(404);
    echo "Arquivo não encontrado.";
    exit;
}

$arquivo = $res->fetch_assoc();

header('Content-Description: File Transfer');
header('Content-Type: ' . $arquivo['tipo_mime']);
header('Content-Disposition: attachment; filename="' . $arquivo['nome_arquivo'] . '"');
header('Content-Length: ' . strlen($arquivo['conteudo']));
echo $arquivo['conteudo'];
exit;
