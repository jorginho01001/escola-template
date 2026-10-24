<?php
require '../config.php'; exige_login();
$status = $_GET['status'] ?? ''; $q = trim($_GET['q'] ?? '');
$sql = 'SELECT * FROM visitas WHERE 1'; $p = [];
if (isset(STATUS[$status])) { $sql .= ' AND status = ?'; $p[] = $status; }
if ($q !== '') { $sql .= ' AND (nome LIKE ? OR telefone LIKE ?)'; $p[] = "%$q%"; $p[] = "%$q%"; }
$st = $pdo->prepare($sql . ' ORDER BY criado_em DESC'); $st->execute($p); $lista = $st->fetchAll();
$cont = $pdo->query('SELECT status, COUNT(*) n FROM visitas GROUP BY status')->fetchAll(PDO::FETCH_KEY_PAIR);
?><!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Visitas | Painel</title><link rel="stylesheet" href="admin.css"></head>
<body>
<?php include '_menu.php'; ?>
<main class="wrap">
  <div class="head"><h1>Visitas agendadas</h1><a class="btn" href="editar.php?id=0">+ Nova visita</a></div>
  <?php if (isset($_GET['ok'])): ?><div class="alert ok">Alteração salva com sucesso.</div><?php endif; ?>

  <div class="stats">
    <?php foreach (STATUS as $k => $nome): ?>
      <a href="?status=<?= $k ?>" class="stat s-<?= $k ?>"><b><?= (int)($cont[$k] ?? 0) ?></b><span><?= $nome ?></span></a>
    <?php endforeach; ?>
  </div>

  <form class="filtros" method="get">
    <input name="q" value="<?= e($q) ?>" placeholder="Buscar por nome ou telefone">
    <select name="status"><option value="">Todos os status</option>
      <?php foreach (STATUS as $k => $nome): ?><option value="<?= $k ?>" <?= $k === $status ? 'selected' : '' ?>><?= $nome ?></option><?php endforeach; ?>
    </select>
    <button class="btn alt">Filtrar</button>
  </form>

  <table>
    <thead><tr><th>Responsável</th><th>WhatsApp</th><th>Série</th><th>Status</th><th>Recebido em</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($lista as $v): ?>
      <tr>
        <td data-l="Responsável"><strong><?= e($v['nome']) ?></strong><small><?= e($v['observacao']) ?></small></td>
        <td data-l="WhatsApp"><a href="https://wa.me/55<?= preg_replace('/\D/', '', $v['telefone']) ?>" target="_blank" rel="noopener"><?= e($v['telefone']) ?></a></td>
        <td data-l="Série"><?= e($v['serie']) ?></td>
        <td data-l="Status"><span class="pill s-<?= e($v['status']) ?>"><?= STATUS[$v['status']] ?></span></td>
        <td data-l="Recebido"><?= date('d/m/Y H:i', strtotime($v['criado_em'])) ?></td>
        <td class="acoes">
          <a class="btn sm" href="editar.php?id=<?= $v['id'] ?>">Editar</a>
          <form method="post" action="excluir.php" onsubmit="return confirm('Excluir esta visita?')">
            <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $v['id'] ?>">
            <button class="btn sm danger">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; if (!$lista): ?><tr><td colspan="6" class="vazio">Nenhuma visita encontrada.</td></tr><?php endif; ?>
    </tbody>
  </table>
</main></body></html>
