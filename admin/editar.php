<?php
require '../config.php'; exige_login();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$v = ['nome'=>'','telefone'=>'','serie'=>SERIES[0],'status'=>'novo','observacao'=>''];
if ($id) {
    $st = $pdo->prepare('SELECT * FROM visitas WHERE id = ?'); $st->execute([$id]);
    $v = $st->fetch() ?: exit('Registro não encontrado.');
}
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checa_csrf();
    $d = [trim($_POST['nome'] ?? ''), trim($_POST['telefone'] ?? ''), $_POST['serie'] ?? '', $_POST['status'] ?? '', trim($_POST['observacao'] ?? '')];
    if ($d[0] === '' || strlen(preg_replace('/\D/', '', $d[1])) < 10 || !in_array($d[2], SERIES, true) || !isset(STATUS[$d[3]])) {
        $erro = 'Confira nome, telefone, série e status.';
        $v = array_combine(['nome','telefone','serie','status','observacao'], $d);
    } else {
        if ($id) { $pdo->prepare('UPDATE visitas SET nome=?, telefone=?, serie=?, status=?, observacao=? WHERE id=?')->execute([...$d, $id]); }
        else     { $pdo->prepare('INSERT INTO visitas (nome, telefone, serie, status, observacao) VALUES (?,?,?,?,?)')->execute($d); }
        header('Location: index.php?ok=1'); exit;
    }
}
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $id ? 'Editar' : 'Nova' ?> visita | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body>
<?php include '_menu.php'; ?>
<main class="wrap narrow">
  <div class="head"><h1><?= $id ? 'Editar visita' : 'Nova visita' ?></h1><a href="index.php">← Voltar</a></div>
  <?php if ($erro): ?><div class="alert err"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" class="card form">
    <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $id ?>">
    <label>Nome do responsável<input name="nome" value="<?= e($v['nome']) ?>" maxlength="120" required></label>
    <label>WhatsApp<input name="telefone" value="<?= e($v['telefone']) ?>" required></label>
    <label>Série de interesse<select name="serie"><?php foreach (SERIES as $s): ?><option <?= $s === $v['serie'] ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?></select></label>
    <label>Status<select name="status"><?php foreach (STATUS as $k => $n): ?><option value="<?= $k ?>" <?= $k === $v['status'] ? 'selected' : '' ?>><?= $n ?></option><?php endforeach; ?></select></label>
    <label>Observações<textarea name="observacao" rows="4"><?= e($v['observacao']) ?></textarea></label>
    <button class="btn">Salvar</button>
  </form>
</main></body></html>
