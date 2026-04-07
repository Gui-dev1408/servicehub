CREATE DATABASE IF NOT EXISTS servicehubdb01 CHARACTER SET utf8;
USE servicehubdb01;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  tipo INT NOT NULL DEFAULT 2 COMMENT '1 - Administrador 2 - Cliente 3 - Prestador',
  ativo BIT NOT NULL DEFAULT 1,
  primeiro_login BIT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE (email)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS servicos (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  descontinuado BIT NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS clientes (
  id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  cpf CHAR(11) NULL,
  PRIMARY KEY (id),
  INDEX (usuario_id),
  CONSTRAINT fk_clientes_usuarios FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS solicitacoes (
  id INT NOT NULL AUTO_INCREMENT,
  cliente_id INT NOT NULL,
  descricao_problema TEXT NOT NULL,
  data_preferida TIMESTAMP NULL,
  status INT NOT NULL DEFAULT 1 COMMENT '1 pendente 2 em_andamento 3 finalizada 4 cancelada 5 recusada',
  data_cad TIMESTAMP NOT NULL DEFAULT current_timestamp,
  data_atualizacao DATETIME NULL,
  data_resposta DATETIME NULL,
  resposta_admin TEXT NULL,
  endereco VARCHAR(200) NOT NULL,
  PRIMARY KEY (id),
  INDEX (cliente_id),
  CONSTRAINT fk_solicitacoes_clientes FOREIGN KEY (cliente_id)
    REFERENCES clientes(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS servico_solicitacao (
  servico_id INT NOT NULL,
  solicitacao_id INT NOT NULL,
  data_assoc TIMESTAMP NOT NULL DEFAULT current_timestamp,
  INDEX (servico_id),
  INDEX (solicitacao_id),
  CONSTRAINT fk_ss_servicos FOREIGN KEY (servico_id)
    REFERENCES servicos(id),
  CONSTRAINT fk_ss_solicitacoes FOREIGN KEY (solicitacao_id)
    REFERENCES solicitacoes(id)
) ENGINE=InnoDB;

-- ADMIN PADRÃO (senha: admin123)
INSERT INTO usuarios(nome,email,senha,tipo,ativo,primeiro_login)
VALUES (
  'Administrador',
  'admin@servicehub.com',
  '$2y$10$XU3xHh5a4T6XyF2u0zQp7uRkU7yYz6o4qZlW0mV9P0uF8qZQh5p1C',
  1,
  1,
  0
);

-- SERVIÇOS PADRÃO
INSERT INTO servicos(nome,descricao,preco) VALUES
('Formatação de Computador','Formatação completa com instalação e otimização.',150.00),
('Limpeza Interna','Limpeza física e troca de pasta térmica.',120.00),
('Instalação de Rede','Configuração de rede local e Wi-Fi.',200.00),
('Backup de Dados','Backup completo em mídia externa ou nuvem.',180.00);