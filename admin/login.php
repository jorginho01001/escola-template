<?php
require '../config.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checa_csrf();
    $st = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = ?');
    $st->execute([trim($_POST['usuario'] ?? '')]);
    $u = $st->fetch();
    if ($u && password_verify($_POST['senha'] ?? '', $u['senha_hash'])) {
        session_regenerate_id(true);
        $_SESSION['uid'] = $u['id'];
        header('Location: index.php'); exit;
    }
    sleep(1);
    $erro = 'Usuário ou senha incorretos.';
}
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Entrar | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body class="login-page">
<form method="post" class="login-box">
  <h1>Painel da Secretaria</h1><p>Colégio Ipê Amarelo</p>
  <?php if ($erro): ?><div class="alert err"><?= e($erro) ?></div><?php endif; ?>
  <input type="hidden" name="csrf" value="<?= csrf() ?>">
  <label>Usuário<input name="usuario" required autofocus></label>
  <label>Senha<input type="password" name="senha" required></label>
  <button class="btn">Entrar</button>
</form></body></html>
