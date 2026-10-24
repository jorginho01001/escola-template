<?php
// Ajuste para o seu ambiente (XAMPP padrão: root sem senha)
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=escola;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
const STATUS = ['novo'=>'Novo','contatado'=>'Contatado','agendado'=>'Agendado','concluido'=>'Concluído','cancelado'=>'Cancelado'];
const SERIES = ['Educação Infantil','Fundamental I','Fundamental II','Ensino Médio'];
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf(){ return $_SESSION['csrf'] ??= bin2hex(random_bytes(16)); }
function checa_csrf(){ if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Requisição inválida.'); } }
function exige_login(){ if (empty($_SESSION['uid'])) { header('Location: login.php'); exit; } }

// ---- Textos editáveis do site (valor padrão; o painel "Textos e fotos" sobrescreve) ----
const DEFAULTS = [
  'hero_titulo' => 'A conquista de cada aluno é o que nos faz crescer',
  'sobre_p1'    => 'O Colégio Ipê Amarelo tem mais de quatro décadas de história e amor pela educação. Uma combinação de excelência que faz nossa escola crescer com credibilidade, mantendo a confiança das famílias do bairro.',
  'sobre_p2'    => 'Nosso ensino segue padrões que equilibram tradição e inovação, oferecendo aos alunos o melhor ambiente para a sua trajetória em busca do sucesso.',
  'endereco'    => 'Rua das Palmeiras, 123 – Centro, Manaus/AM',
  'telefone'    => '(92) 3000-0000',
  'horario'     => 'Seg a Sex, 7h às 17h',
  'whatsapp'    => '5592999999999',
  'instagram'   => 'https://instagram.com/',
];
function conf($k){
    static $c = null; global $pdo;
    if ($c === null) { try { $c = $pdo->query('SELECT chave, valor FROM site_config')->fetchAll(PDO::FETCH_KEY_PAIR); } catch (Throwable $e) { $c = []; } }
    return ($c[$k] ?? '') !== '' ? $c[$k] : (DEFAULTS[$k] ?? '');
}
function foto($k){ $f = conf('foto_'.$k); return $f ? 'style="background-image:url(\''.e($f).'\')"' : ''; }
function salva_imagem($f){
    if (($f['error'] ?? 4) !== UPLOAD_ERR_OK) return null;
    if ($f['size'] > 3*1024*1024) throw new Exception('Imagem maior que 3 MB.');
    $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name'])] ?? null;
    if (!$ext) throw new Exception('Use imagem JPG, PNG ou WEBP.');
    $dir = __DIR__.'/uploads';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $nome = 'uploads/'.bin2hex(random_bytes(8)).'.'.$ext;
    move_uploaded_file($f['tmp_name'], __DIR__.'/'.$nome);
    return $nome;
}
