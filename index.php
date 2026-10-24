<?php
require 'config.php';
try { $posts = $pdo->query('SELECT id, titulo, resumo, imagem, criado_em FROM posts WHERE publicado = 1 ORDER BY criado_em DESC LIMIT 3')->fetchAll(); } catch (Throwable $e) { $posts = []; }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Colégio Ipê Amarelo | Educação com tradição no bairro</title>
<meta name="description" content="Há mais de 40 anos formando crianças e jovens com carinho e excelência.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;800&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="topbar">
  <a href="#visita">Agende sua visita</a>
  <a href="#ensino">Tour virtual</a>
  <a href="#contato" class="topbar-dark">Área do aluno</a>
</div>

<header class="header">
  <a href="#inicio" class="logo">
    <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 3C24 3 8 22 8 32a16 16 0 0 0 32 0C40 22 24 3 24 3z" fill="#f9d835" stroke="#232c55" stroke-width="3"/><path d="M17 33l7-9 7 9" fill="none" stroke="#232c55" stroke-width="3" stroke-linecap="round"/></svg>
    <span>Colégio<strong>Ipê Amarelo</strong></span>
  </a>
  <button class="burger" aria-label="Abrir menu" aria-expanded="false"><span></span><span></span><span></span></button>
  <nav class="nav" id="menu">
    <a href="#sobre" style="--c:#f9d835">Sobre nós</a>
    <a href="#ensino" style="--c:#232c55">O que ensinamos</a>
    <a href="#vida" style="--c:#3fb3e4">Vida escolar</a>
    <a href="#visita" style="--c:#e07b25">Matrículas</a>
    <a href="#contato" style="--c:#8bc34a">Fale conosco</a>
  </nav>
</header>

<main id="inicio">
  <section class="hero" aria-label="Destaques">
    <div class="slide on s1">
      <div class="cta-card"><h1><?= e(conf("hero_titulo")) ?></h1><a href="#visita">Agende sua visita</a></div>
      <p class="slide-text">Aqui o Pedro encontrou<br>o espaço para se<br><b>desenvolver e<br>fazer amigos.</b></p>
    </div>
    <div class="slide s2">
      <div class="cta-card"><h2>Resultados em provas e olimpíadas</h2><a href="#vida">Confira aqui</a></div>
      <div class="badge-box"><small>Nossos alunos são</small><b>Destaque</b><span>em olimpíadas do bairro</span></div>
    </div>
    <div class="slide s3">
      <div class="cta-card"><h2>Matrículas abertas para 2027</h2><a href="#contato">Fale conosco</a></div>
      <p class="slide-text"><b>Vagas limitadas</b><br>para todas as turmas.</p>
    </div>
    <button class="arrow prev" aria-label="Anterior">&#8249;</button>
    <button class="arrow next" aria-label="Próximo">&#8250;</button>
    <div class="dots"></div>
  </section>

  <section class="sobre" id="sobre">
    <div class="sobre-card">
      <div class="sobre-text">
        <span class="tag">Sobre nós</span>
        <h2>Bem-vindos à nossa escola!</h2>
        <hr>
        <p><?= e(conf("sobre_p1")) ?></p>
        <p><?= e(conf("sobre_p2")) ?></p>
        <a href="#ensino" class="btn-orange">Saiba mais</a>
      </div>
      <div class="photo p-sobre" <?= foto("sobre") ?> role="img" aria-label="Aluna estudando"></div>
    </div>
  </section>

  <section class="video">
    <div class="video-box photo p-video" <?= foto("video") ?>>
      <button class="play" aria-label="Assistir vídeo institucional"></button>
      <p>Conheça nossa escola por dentro</p>
    </div>
  </section>

  <section class="ensino" id="ensino">
    <div class="ensino-inner">
      <div class="ensino-left">
        <div class="photo p-ensino" <?= foto("ensino") ?> role="img" aria-label="Alunos no corredor"></div>
        <span class="tag">Ensino</span>
        <h2>Nossa abordagem para aprender e ensinar</h2>
      </div>
      <ul class="niveis">
        <li style="--c:#3fb3e4"><h3>Educação Infantil</h3><p>Dos 2 aos 5 anos, nossos pequenos contam com ambientes acolhedores e equipe preparada para o desenvolvimento pleno.</p></li>
        <li style="--c:#8bc34a"><h3>Ensino Fundamental I</h3><p>Do 1º ao 5º ano, momento de adquirir responsabilidade, autonomia e fortalecer o lado emocional.</p></li>
        <li style="--c:#e07b25"><h3>Ensino Fundamental II</h3><p>Do 6º ao 9º ano, aperfeiçoamento da leitura, escrita e do raciocínio abstrato.</p></li>
        <li style="--c:#f9d835"><h3>Ensino Médio</h3><p>Preparação sólida para o ENEM e vestibulares, com acompanhamento próximo de cada aluno.</p></li>
      </ul>
    </div>
  </section>

  <section class="numeros" id="vida">
    <div><b>40+</b><span>anos de história</span></div>
    <div><b>1.200</b><span>alunos já formados</span></div>
    <div><b>35</b><span>professores dedicados</span></div>
    <div><b>100%</b><span>de carinho em cada sala</span></div>
  </section>

  <?php if ($posts): ?>
  <section class="novidades" id="novidades"><div class="nov-inner">
    <span class="tag">Novidades</span><h2>Fique por dentro</h2>
    <div class="nov-grid">
    <?php foreach ($posts as $p): ?>
      <a class="nov-card" href="post.php?id=<?= $p['id'] ?>">
        <div class="photo nov-img" <?= $p['imagem'] ? 'style="background-image:url(\''.e($p['imagem']).'\')"' : '' ?>></div>
        <div class="nov-body"><small><?= date('d/m/Y', strtotime($p['criado_em'])) ?></small><h3><?= e($p['titulo']) ?></h3><p><?= e($p['resumo']) ?></p></div>
      </a>
    <?php endforeach; ?>
    </div></div>
  </section>
  <?php endif; ?>

  <section class="contato" id="contato">
    <div class="contato-info" id="visita">
      <span class="tag">Matrículas</span>
      <h2>Agende sua visita</h2>
      <p>Venha conhecer a estrutura e conversar com nossa equipe pedagógica.</p>
      <p><b>Endereço:</b> <?= e(conf("endereco")) ?><br><b>Telefone:</b> <?= e(conf("telefone")) ?><br><b>Horário:</b> <?= e(conf("horario")) ?></p>
    </div>
    <form class="form" action="contato.php" method="post">
      <label>Nome do responsável<input type="text" name="nome" required></label>
      <label>WhatsApp<input type="tel" name="telefone" required></label>
      <label>Série de interesse
        <select name="serie"><option>Educação Infantil</option><option>Fundamental I</option><option>Fundamental II</option><option>Ensino Médio</option></select>
      </label>
      <button type="submit" class="btn-orange">Quero visitar a escola</button>
    </form>
  </section>
</main>

<footer class="footer">
  <p>© 2026 Colégio Ipê Amarelo. Todos os direitos reservados.</p>
  <p>Site de demonstração</p>
</footer>

<div class="float">
  <a href="<?= e(conf("instagram")) ?>" class="f-ig" aria-label="Instagram" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="#fff"/></svg></a>
  <a href="https://wa.me/<?= e(conf("whatsapp")) ?>" class="f-wa" aria-label="WhatsApp" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l1.6-5A9 9 0 1 1 8 19.400L3 21z"/><path d="M9 8.500c0 3.500 3 6.500 6.500 6.500l1.200-1.500-2.200-1-1 .8c-1-.4-2-1.400-2.400-2.400l.8-1-1-2.200L9 8.500z" fill="#fff" stroke="none"/></svg></a>
</div>

<script src="script.js"></script>
</body>
</html>
