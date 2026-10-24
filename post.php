<?php
require 'config.php';
$st = $pdo->prepare('SELECT * FROM posts WHERE id = ? AND publicado = 1'); $st->execute([(int)($_GET['id'] ?? 0)]);
$p = $st->fetch();
if (!$p) { http_response_code(404); exit('Publicação não encontrada.'); }
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($p['titulo']) ?> | Colégio Ipê Amarelo</title>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;800&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css"></head>
<body>
<header class="header"><a href="index.php" class="logo"><span>Colégio<strong>Ipê Amarelo</strong></span></a><a href="index.php#novidades" class="btn-orange">← Voltar ao site</a></header>
<article class="artigo">
  <small><?= date('d/m/Y', strtotime($p['criado_em'])) ?></small>
  <h1><?= e($p['titulo']) ?></h1>
  <?php if ($p['imagem']): ?><img src="<?= e($p['imagem']) ?>" alt=""><?php endif; ?>
  <div><?= nl2br(e($p['conteudo'])) ?></div>
</article>
</body></html>
