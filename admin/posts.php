<?php
require '../config.php'; exige_login();
$lista = $pdo->query('SELECT * FROM posts ORDER BY criado_em DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Publicações | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body><?php include '_menu.php'; ?>
<main class="wrap">
  <div class="head"><h1>Publicações</h1><a class="btn" href="post_editar.php?id=0">+ Nova publicação</a></div>
  <?php if (isset($_GET['ok'])): ?><div class="alert ok">Alteração salva com sucesso.</div><?php endif; ?>
  <table>
    <thead><tr><th>Título</th><th>Situação</th><th>Data</th><th></th></tr></thead><tbody>
    <?php foreach ($lista as $p): ?>
      <tr>
        <td data-l="Título"><strong><?= e($p['titulo']) ?></strong><small><?= e($p['resumo']) ?></small></td>
        <td data-l="Situação"><span class="pill <?= $p['publicado'] ? 's-concluido' : 's-cancelado' ?>"><?= $p['publicado'] ? 'Publicado' : 'Rascunho' ?></span></td>
        <td data-l="Data"><?= date('d/m/Y', strtotime($p['criado_em'])) ?></td>
        <td class="acoes">
          <a class="btn sm" href="post_editar.php?id=<?= $p['id'] ?>">Editar</a>
          <form method="post" action="post_excluir.php" onsubmit="return confirm('Excluir esta publicação?')">
            <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button class="btn sm danger">Excluir</button></form>
        </td>
      </tr>
    <?php endforeach; if (!$lista): ?><tr><td colspan="4" class="vazio">Nenhuma publicação ainda.</td></tr><?php endif; ?>
    </tbody>
  </table>
</main></body></html>
