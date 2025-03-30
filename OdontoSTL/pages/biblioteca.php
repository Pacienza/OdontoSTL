<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.php?page=login");
  exit;
}
require_once 'includes/auth.php';
exigir_login(); // redireciona se não estiver logado


$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT p.id, p.nome, p.midia_principal, p.descricao FROM produtos p
  INNER JOIN usuarios_produtos up ON p.id = up.produto_id
  WHERE up.usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="biblioteca">
  <h1>Minha Biblioteca</h1>
  <div class="grid">
    <?php while ($produto = $result->fetch_assoc()): ?>
      <div class="card">
        <img src="<?= $produto['midia_principal'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p><?= htmlspecialchars($produto['descricao']) ?></p>
        <a href="scripts/download.php?id=<?= $produto['id'] ?>" class="btn">Baixar STL</a>

      </div>
    <?php endwhile; ?>
  </div>
</section>

<style>
.biblioteca {
  padding: 2rem;
}
.biblioteca h1 {
  text-align: center;
  margin-bottom: 2rem;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
}
.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1rem;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  margin-bottom: 1rem;
}
.card .btn {
  display: inline-block;
  padding: 0.5rem 1rem;
  background-color: #28a745;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
}
.card .btn:hover {
  background-color: #218838;
}
</style>
