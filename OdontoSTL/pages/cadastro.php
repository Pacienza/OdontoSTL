<?php
require_once 'includes/db.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = $_POST['senha'];
  $cpf = trim($_POST['cpf']);
  $telefone = trim($_POST['telefone']);
  $endereco = trim($_POST['endereco']);

  if (!$nome || !$email || !$senha || !$cpf || !$telefone || !$endereco) {
    $erro = "Preencha todos os campos obrigatórios.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $erro = "Email já cadastrado.";
    } else {
      $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nome, $email, $senha_hash);
      if ($stmt->execute()) {
        header("Location: index.php?page=login&cadastro=sucesso");
        exit;
      } else {
        $erro = "Erro ao cadastrar. Tente novamente.";
      }
    }
  }
}
?>

<section class="formulario">
  <h1>Cadastro</h1>
  <?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
  <?php endif; ?>
  <form method="POST">
    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="text" name="cpf" placeholder="CPF" required>
    <input type="text" name="telefone" placeholder="Telefone (com DDD)" required>
    <input type="text" name="endereco" placeholder="Endereço completo" required>
    <button type="submit">Cadastrar</button>
  </form>
  <p>Já tem conta? <a href="index.php?page=login">Entrar</a></p>
</section>

<style>
.formulario {
  max-width: 500px;
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