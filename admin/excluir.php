<?php
require '../config.php'; exige_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checa_csrf();
    $pdo->prepare('DELETE FROM visitas WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
}
header('Location: index.php?ok=1');
