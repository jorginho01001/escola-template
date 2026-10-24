<?php $pg = basename($_SERVER['SCRIPT_NAME']); $on = fn($a) => in_array($pg, $a) ? 'on' : ''; ?>
<header class="top"><strong>Colégio Ipê Amarelo</strong>
  <nav>
    <a class="<?= $on(['index.php','editar.php']) ?>" href="index.php">Visitas</a>
    <a class="<?= $on(['posts.php','post_editar.php']) ?>" href="posts.php">Publicações</a>
    <a class="<?= $on(['site.php']) ?>" href="site.php">Textos e fotos</a>
    <a href="../index.php" target="_blank">Ver site ↗</a>
  </nav><a href="sair.php">Sair</a></header>
