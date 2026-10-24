<?php
require '../config.php'; exige_login();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$p = ['titulo'=>'','resumo'=>'','conteudo'=>'','imagem'=>null,'publicado'=>1];
if ($id) { $st = $pdo->prepare('SELECT * FROM posts WHERE id = ?'); $st->execute([$id]); $p = $st->fetch() ?: exit('Publicação não encontrada.'); }
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checa_csrf();
    $p = array_merge($p, ['titulo'=>trim($_POST['titulo'] ?? ''), 'resumo'=>trim($_POST['resumo'] ?? ''), 'conteudo'=>trim($_POST['conteudo'] ?? ''), 'publicado'=>isset($_POST['publicado']) ? 1 : 0]);
    try {
        if ($p['titulo'] === '' || mb_strlen($p['titulo']) > 150 || $p['conteudo'] === '') throw new Exception('Preencha o título (até 150 caracteres) e o conteúdo.');
        $p['imagem'] = salva_imagem($_FILES['imagem'] ?? []) ?: $p['imagem'];
        $d = [$p['titulo'], mb_substr($p['resumo'], 0, 255), $p['conteudo'], $p['imagem'], $p['publicado']];
        if ($id) $pdo->prepare('UPDATE posts SET titulo=?, resumo=?, conteudo=?, imagem=?, publicado=? WHERE id=?')->execute([...$d, $id]);
        else     $pdo->prepare('INSERT INTO posts (titulo, resumo, conteudo, imagem, publicado) VALUES (?,?,?,?,?)')->execute($d);
        header('Location: posts.php?ok=1'); exit;
    } catch (Exception $ex) { $erro = $ex->getMessage(); }
}
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $id ? 'Editar' : 'Nova' ?> publicação | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body><?php include '_menu.php'; ?>
<main class="wrap narrow">
  <div class="head"><h1><?= $id ? 'Editar publicação' : 'Nova publicação' ?></h1><a href="posts.php">← Voltar</a></div>
  <?php if ($erro): ?><div class="alert err"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data" class="card form">
    <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $id ?>">
    <label>Título<input name="titulo" value="<?= e($p['titulo']) ?>" maxlength="150" required></label>
    <label>Resumo (aparece no card da página inicial)<input name="resumo" value="<?= e($p['resumo']) ?>" maxlength="255"></label>
    <label>Conteúdo<textarea name="conteudo" rows="8" required><?= e($p['conteudo']) ?></textarea></label>
    <label>Foto de capa (JPG, PNG ou WEBP, até 3 MB)
      <?php if ($p['imagem']): ?><img class="thumb" src="../<?= e($p['imagem']) ?>" alt=""><?php endif; ?>
      <input type="file" name="imagem" accept="image/jpeg,image/png,image/webp"></label>
    <label class="check"><input type="checkbox" name="publicado" <?= $p['publicado'] ? 'checked' : '' ?>> Publicar no site</label>
    <button class="btn">Salvar</button>
  </form>
</main></body></html>
