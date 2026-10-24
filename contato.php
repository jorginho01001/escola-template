<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$nome  = trim($_POST['nome'] ?? '');
$tel   = trim($_POST['telefone'] ?? '');
$serie = $_POST['serie'] ?? '';
if ($nome === '' || mb_strlen($nome) > 120 || strlen(preg_replace('/\D/', '', $tel)) < 10 || !in_array($serie, SERIES, true)) {
    header('Location: index.php?erro=1#contato'); exit;
}
$pdo->prepare('INSERT INTO visitas (nome, telefone, serie) VALUES (?,?,?)')->execute([$nome, $tel, $serie]);
header('Location: index.php?enviado=1#contato');
