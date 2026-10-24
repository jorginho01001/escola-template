CREATE DATABASE IF NOT EXISTS escola CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE escola;
CREATE TABLE IF NOT EXISTS visitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  serie VARCHAR(40) NOT NULL,
  status ENUM('novo','contatado','agendado','concluido','cancelado') NOT NULL DEFAULT 'novo',
  observacao TEXT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(40) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL
);
-- Dados de exemplo para os prints
INSERT INTO visitas (nome, telefone, serie, status, observacao) VALUES
('Mariana Souza','(92) 99111-2233','Educação Infantil','novo',NULL),
('Carlos Pereira','(92) 98822-3344','Fundamental I','contatado','Ligar de novo na quinta'),
('Ana Beatriz Lima','(92) 99333-4455','Ensino Médio','agendado','Visita sábado 9h'),
('Roberto Alves','(92) 98144-5566','Fundamental II','concluido','Matriculou 2 filhos'),
('Juliana Costa','(92) 99455-6677','Educação Infantil','cancelado','Mudou de bairro');
