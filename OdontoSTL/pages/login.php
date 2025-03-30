<?php
require_once 'includes/db.php';
session_start();

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $senha = $_POST['senha'];

  if (!$email || !$senha) {
    $erro = "Preencha todos os campos.";
  } else {
    $stmt = $conn->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
      $stmt->bind_result($id, $nome, $senha_hash);
      $stmt->fetch();

      if (password_verify($senha, $senha_hash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $nome;
        header("Location: index.php?page=biblioteca");
        exit;
      } else {
        $erro = "Senha incorreta.";
      }
    } else {
      $erro = "Usuário não encontrado.";
    }
  }
}
?>

<section class="formulario">
  <h1>Login</h1>
  <?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
  <?php endif; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
  </form>
  <p>Não tem uma conta? <a href="index.php?page=cadastro">Cadastre-se</a></p>
</section>

<style>
.formulario {
  max-width: 400px;
  margin: 2rem auto;
  padding: 2rem;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  text-align: center;
}
.formulario h1 {
  margin-bottom: 1rem;
}
.formulario input {
  display: block;
  width: 100%;
  padding: 0.8rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.formulario button {
  padding: 0.8rem 2rem;
  background-color: #007BFF;
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
}
.formulario button:hover {
  background-color: #0056b3;
}
.formulario .erro {
  color: red;
  margin-bottom: 1rem;
}
</style>
