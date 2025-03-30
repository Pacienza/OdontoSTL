<?php
$id = basename($_GET['id']);


if (!$id || !is_numeric($id)) {
  echo "<p>Produto inválido ou não encontrado.</p>";
  return;
}

$caminho = "pages/produtos/{$id}.php";

if (file_exists($caminho)) {
  include $caminho;
} else {
  echo "<p>Produto não encontrado.</p>";
}
?>
