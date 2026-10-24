<?php
require '../config.php'; exige_login();
$campos = [
  'hero_titulo'=>['Título do banner principal','text'], 'sobre_p1'=>['Sobre nós – 1º parágrafo','area'], 'sobre_p2'=>['Sobre nós – 2º parágrafo','area'],
  'endereco'=>['Endereço','text'], 'telefone'=>['Telefone','text'], 'horario'=>['Horário de atendimento','text'],
  'whatsapp'=>['WhatsApp (só números, com 55 e DDD)','text'], 'instagram'=>['Link do Instagram (https://...)','text'],
];
$fotos = ['sobre'=>'Foto da seção "Sobre nós"', 'video'=>'Imagem do vídeo institucional', 'ensino'=>'Foto da seção "Ensino"'];
$erro = ''; $salvo = isset($_GET['ok']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checa_csrf();
    $up = $pdo->prepare('INSERT INTO site_config (chave, valor) VALUES (?,?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');
    try {
        foreach ($campos as $k => $_) {
            $v = trim($_POST[$k] ?? '');
            if ($k === 'whatsapp') $v = preg_replace('/\D/', '', $v);
            if ($k === 'instagram' && $v !== '' && !preg_match('#^https?://#', $v)) throw new Exception('O link do Instagram deve começar com https://');
            $up->execute([$k, $v]);
        }
        foreach ($fotos as $k => $_) if ($img = salva_imagem($_FILES['foto_'.$k] ?? [])) $up->execute(['foto_'.$k, $img]);
        header('Location: site.php?ok=1'); exit;
    } catch (Exception $ex) { $erro = $ex->getMessage(); }
}
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Textos e fotos | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body><?php include '_menu.php'; ?>
<main class="wrap narrow">
  <div class="head"><h1>Textos e fotos do site</h1></div>
  <?php if ($salvo): ?><div class="alert ok">Site atualizado.</div><?php endif; ?>
  <?php if ($erro): ?><div class="alert err"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data" class="card form">
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <?php foreach ($campos as $k => [$rot, $tipo]): ?>
      <label><?= $rot ?>
        <?php if ($tipo === 'area'): ?><textarea name="<?= $k ?>" rows="4"><?= e(conf($k)) ?></textarea>
        <?php else: ?><input name="<?= $k ?>" value="<?= e(conf($k)) ?>"><?php endif; ?></label>
    <?php endforeach; ?>
    <?php foreach ($fotos as $k => $rot): $f = conf('foto_'.$k); ?>
      <label><?= $rot ?>
        <?php if ($f): ?><img class="thumb" src="../<?= e($f) ?>" alt=""><?php endif; ?>
        <input type="file" name="foto_<?= $k ?>" accept="image/jpeg,image/png,image/webp"></label>
    <?php endforeach; ?>
    <button class="btn">Salvar alterações</button>
  </form>
</main></body></html>
