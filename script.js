// Menu mobile
const burger = document.querySelector('.burger'), menu = document.getElementById('menu');
burger.addEventListener('click', () => {
  const open = menu.classList.toggle('open');
  burger.setAttribute('aria-expanded', open);
});
menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => menu.classList.remove('open')));

// Slider do banner
const slides = [...document.querySelectorAll('.slide')], dotsBox = document.querySelector('.dots');
let i = 0, timer;
slides.forEach((_, n) => {
  const d = document.createElement('button');
  d.setAttribute('aria-label', 'Slide ' + (n + 1));
  d.onclick = () => { go(n); restart(); };
  dotsBox.appendChild(d);
});
function go(n) {
  i = (n + slides.length) % slides.length;
  slides.forEach((s, k) => s.classList.toggle('on', k === i));
  [...dotsBox.children].forEach((d, k) => d.classList.toggle('on', k === i));
}
function restart() {
  clearInterval(timer);
  if (!matchMedia('(prefers-reduced-motion: reduce)').matches) timer = setInterval(() => go(i + 1), 6000);
}
document.querySelector('.prev').onclick = () => { go(i - 1); restart(); };
document.querySelector('.next').onclick = () => { go(i + 1); restart(); };
go(0); restart();

// Aviso após enviar o formulário (contato.php redireciona com ?enviado=1 ou ?erro=1)
const params = new URLSearchParams(location.search);
if (params.has('enviado') || params.has('erro')) {
  const ok = params.has('enviado');
  const form = document.querySelector('.form');
  const aviso = document.createElement('p');
  aviso.setAttribute('role', 'status');
  aviso.style.cssText = 'background:#fff;padding:12px;font-weight:700;border-left:5px solid ' + (ok ? '#8bc34a' : '#b3261e');
  aviso.textContent = ok ? 'Recebemos seu pedido! Entraremos em contato pelo WhatsApp.' : 'Confira os dados e tente novamente.';
  form.prepend(aviso);
}
