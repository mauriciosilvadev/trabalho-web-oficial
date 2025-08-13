# Sistema de Controle de Serviços

Um sistema web completo para gerenciamento de serviços desenvolvido em PHP com arquitetura MVC, permitindo o cadastro, contratação e administração de serviços diversos.

## 📋 Sobre o Projeto

Este sistema foi desenvolvido como parte de um trabalho prático acadêmico e implementa uma plataforma de marketplace de serviços onde:

- **Prestadores** podem cadastrar e gerenciar seus serviços
- **Clientes** podem navegar, contratar e acompanhar serviços
- **Administradores** têm controle total sobre usuários e serviços

## 🚀 Funcionalidades

### Para Visitantes
- Visualização de serviços disponíveis
- Cadastro de nova conta
- Login no sistema
- Carrinho de compras

### Para Clientes (C)
- Contratação de serviços
- Gerenciamento do carrinho
- Visualização de serviços contratados
- Atualização de dados pessoais

### Para Prestadores (P)
- Cadastro de novos serviços
- Gerenciamento de serviços oferecidos
- Definição de datas disponíveis
- Visualização de serviços vendidos
- Atualização de dados pessoais

### Para Administradores (A)
- Gerenciamento completo de usuários
- Visualização de todos os serviços
- Consulta de vendas realizadas
- Controle total do sistema

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 8.2+
- **Banco de Dados:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework CSS:** Bootstrap 5.2.3
- **Servidor Web:** Apache (XAMPP)
- **Arquitetura:** MVC (Model-View-Controller)

## 📁 Estrutura do Projeto

```
controle-produtos-main/
├── classes/              # Modelos de dados (Entities)
│   ├── usuario.inc.php
│   ├── servico.inc.php
│   ├── venda.inc.php
│   ├── tipo.inc.php
│   ├── item.inc.php
│   └── dataDisponivel.inc.php
├── controllers/          # Controladores (Lógica de negócio)
│   ├── controllerUsuario.php
│   ├── controllerServico.php
│   ├── controllerCarrinho.php
│   ├── controllerVenda.php
│   └── controllerTipo.php
├── dao/                  # Data Access Objects (Acesso a dados)
│   ├── conexao.inc.php
│   ├── genericDAO.inc.php
│   ├── usuarioDAO.inc.php
│   ├── servicoDAO.inc.php
│   ├── vendaDAO.inc.php
│   ├── tipoDAO.inc.php
│   └── dataDisponivelDAO.inc.php
├── views/                # Interface do usuário
│   ├── includes/         # Componentes reutilizáveis
│   ├── imagens/          # Recursos visuais
│   └── *.php             # Páginas do sistema
├── utils/                # Funções utilitárias
│   └── funcoesUteis.php
└── BD_TEMA.sql          # Script de criação do banco
```

## ⚙️ Instalação e Configuração

### Pré-requisitos
- XAMPP (Apache + MySQL + PHP)
- Navegador web moderno

### Passos para instalação

1. **Clone ou baixe o projeto**
   ```bash
   # Coloque os arquivos na pasta htdocs do XAMPP
   C:\xampp\htdocs\controle-produtos-main\
   ```

2. **Configure o banco de dados**
   - Inicie o XAMPP (Apache + MySQL)
   - Acesse o phpMyAdmin: `http://localhost/phpmyadmin`
   - Crie um banco chamado `controle_produtos`
   - Importe o arquivo `BD_TEMA.sql`

3. **Configure a conexão**
   - Verifique as configurações em `dao/conexao.inc.php`:
   ```php
   private $servidor_mysql = 'localhost';
   private $nome_banco = 'controle_produtos';
   private $usuario = 'root';
   private $senha = ''; 
   ```

4. **Acesse o sistema**
   - URL: `http://localhost/controle-produtos-main/views/`

## 👥 Usuários de Teste

O sistema vem com usuários pré-cadastrados para teste:

| Tipo | Email | Senha | Descrição |
|------|-------|-------|----------|
| Admin | admin@email | 1234 | Administrador do sistema |
| Prestador | carlos.silva@techmail.com | 12345 | Prestador de serviços |
| Cliente | ana.santos@designmail.com | 12345 | Cliente do sistema |

## 🎯 Como Usar

### Primeiro Acesso
1. Acesse a URL do sistema
2. Faça login com um dos usuários de teste ou cadastre-se
3. Explore as funcionalidades conforme seu tipo de usuário

### Fluxo Principal
1. **Prestador** cadastra serviços e define datas disponíveis
2. **Cliente** navega pelos serviços e adiciona ao carrinho
3. **Cliente** finaliza a compra informando dados de pagamento
4. **Administrador** pode gerenciar todo o sistema

## 🗃️ Banco de Dados

### Principais Tabelas
- `usuarios` - Dados dos usuários (clientes, prestadores, admin)
- `servicos` - Serviços cadastrados
- `tipos` - Categorias de serviços
- `datas_disponiveis` - Datas disponíveis para cada serviço
- `vendas` - Registro das vendas realizadas
- `itens` - Itens de cada venda

## 🔒 Segurança

- Validação de sessões em todas as páginas
- Controle de acesso baseado em tipos de usuário
- Sanitização de dados de entrada
- Proteção contra SQL Injection através de PDO

## 📱 Interface

- Design responsivo com Bootstrap
- Interface intuitiva e moderna
- Navegação adaptada por tipo de usuário
- Feedback visual para ações do usuário

## 🤝 Contribuição

Este é um projeto acadêmico desenvolvido para fins educacionais. Sugestões e melhorias são bem-vindas!

## 📄 Licença

Projeto desenvolvido para fins acadêmicos - DComp UFES, Alegre ES.

---

**Desenvolvido com ❤️ para aprendizado em Desenvolvimento Web**