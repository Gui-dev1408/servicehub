# Mapa do Projeto: ServiceHub

**Modelo de projeto criado durante as aulas de programação WEB PHP**

## 1. Estrutura Geral

O projeto **ServiceHub** é organizado em diretórios e arquivos que separam claramente as responsabilidades entre configuração, componentes reutilizáveis, recursos estáticos e páginas funcionais.

servicehub/
│
├── config/
│   └── conexao.php
│
├── includes/
│   ├── header.php
│   ├── menu.php
* │   ├── funcoes.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── img/
│       ├── banner1.jpg
│       ├── banner2.jpg
│       └── banner3.jpg
│
├── index.php
├── contratar.php
├── processa_contrato.php
│
├── login.php
├── logout.php
* ├── primeiro_login.php
│
├── cliente_dashboard.php
├── cliente_detalhes.php
* ├── cliente_perfil.php
│
├── admin_dashboard.php
├── admin_solicitacoes.php
├── admin_responder.php
│
* ├── admin_servicos.php
* ├── admin_servicos_salvar.php
* ├── admin_servicos_excluir.php
│
└── banco.sql

## 2. Descrição dos Diretórios e Arquivos

### `config/`
Contém arquivos de configuração do sistema.
* **conexao.php**: Responsável pela conexão com o banco de dados.

### `includes/`
Componentes reutilizáveis incluídos em várias páginas para manter a consistência.
* **header.php**: Cabeçalho padrão do site.
* **menu.php**: Menu de navegação principal.
* **footer.php**: Rodapé padrão do site.

### `assets/`
Recursos estáticos utilizados na interface.
* **css/style.css**: Estilos visuais do site.
* **js/scripts.js**: Scripts JavaScript para interatividade.
* **img/**: Imagens utilizadas no layout (Ex: `banner1.jpg`, `banner2.jpg`, `banner3.jpg`).

---

## 3. Páginas Principais
* **index.php**: Página inicial do site, apresentando informações gerais e opções de navegação.
* **contratar.php**: Formulário para contratação de serviços.
* **processa_contrato.php**: Script responsável por processar os dados enviados pelo formulário de contratação ***.

---

## 4. Sistema de Autenticação
* **login.php**: Página de login para clientes e administradores.
* **logout.php**: Finaliza a sessão do usuário e redireciona para a página inicial.

---

## 5. Área do Cliente
* **cliente_dashboard.php**: Painel principal do cliente, exibindo informações sobre solicitações e contratos.
* **cliente_detalhes.php**: Exibe detalhes específicos de uma solicitação ou contrato do cliente.

---

## 6. Área do Administrador
* **admin_dashboard.php**: Painel principal do administrador, com visão geral das solicitações.
* **admin_solicitacoes.php**: Lista de solicitações pendentes ou em andamento.
* **admin_responder.php**: Interface para o administrador responder ou gerenciar solicitações.

---

## 7. Banco de Dados
* **banco.sql**: Arquivo contendo a estrutura (DDL) e dados iniciais (DML) do banco de dados do sistema.

---

## 8. Fluxo Geral do Sistema
1.  O usuário acessa `index.php` e pode navegar pelo site.
2.  Para contratar um serviço, acessa `contratar.php` e envia o formulário.
3.  O envio é processado por `processa_contrato.php`, que grava os dados no banco.
4.  O usuário pode fazer login em `login.php`.
5.  **Após o login com sucesso:**
    * **Clientes** acessam `cliente_dashboard.php` e `cliente_detalhes.php`.
    * **Administradores** acessam `admin_dashboard.php`, `admin_solicitacoes.php` e `admin_responder.php`.
6.  O logout é feito em `logout.php`.


## 9. Instruções de acesso:
1. Admin:
    * email: **admin@servicehub.com**
    * senha: **admin123**
2. Cliente criado automaticamente ao contratar:
    * senha padrão: **123456**
    será obrigado a alterar no primeiro login

> **Nota:** Todas as páginas utilizam os arquivos da pasta `includes/` para manter o layout consistente.