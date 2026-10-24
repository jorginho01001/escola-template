<?php
// Rode UMA vez no navegador e depois APAGUE este arquivo.
require 'config.php';
$usuario = 'secretaria';
$senha   = 'troque-esta-senha-123';
$pdo->prepare('INSERT INTO usuarios (usuario, senha_hash) VALUES (?,?)')
    ->execute([$usuario, password_hash($senha, PASSWORD_DEFAULT)]);
echo 'Usuário criado. Apague este arquivo agora.';
