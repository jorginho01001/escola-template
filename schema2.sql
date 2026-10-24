USE escola;
CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  resumo VARCHAR(255) NULL,
  conteudo TEXT NOT NULL,
  imagem VARCHAR(255) NULL,
  publicado TINYINT(1) NOT NULL DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS site_config (
  chave VARCHAR(50) PRIMARY KEY,
  valor TEXT NULL
);
INSERT INTO posts (titulo, resumo, conteudo) VALUES
('Matrículas abertas para 2027','Garanta a vaga do seu filho com condições especiais.','Estamos com matrículas abertas para todas as turmas.\nAgende uma visita e conheça nossa estrutura.'),
('Feira de Ciências 2026','Os alunos apresentaram projetos incríveis neste sábado.','Foi um dia de muita criatividade, com experimentos e apresentações feitos pelos próprios alunos.'),
('Reunião de pais e mestres','Confira a data e o horário do próximo encontro.','A reunião acontece no auditório da escola. Contamos com a presença de todos.');
