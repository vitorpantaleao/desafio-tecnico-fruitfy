Objective:

Back-end Assessment: [✅] Make all tests pass, applying the best practices of Laravel and SOLID and clean arch

Front-end Assessment: [✅] Implement a front-end using Inertia.js, Vue3 and TailwindCss for contact CRUD

* Plus: Feel free to implement improvements and more features as you wish, such as sending an email to the contact when that contact is deleted from the system.

# Installation
1. Clone the repository
2. Have PHP 8.3 installed on your machine, composer 2, and activate the extensions requested by composer when running "composer install"
3. Run "Composer install"
4. Create a .env file and paste the contents of .env.example
5. Run the command php artisan key:generate
6. Run the command php artisan test, solve the tests

7. After the test is complete, create a repository on github, and upload your resolution to the repository
8. Send the repository link to WhatsApp +55 41 98702-5814

==================================== FIM DAS INSTRUÇÕES ====================================

# Instruções Completas para o Avaliador

## **Pré-requisitos**
- PHP 8.3+
- Composer 2+
- Node.js 20.19+ 
- SQLite

## **Instalação e Configuração**

### 1. **Clone e Dependências**
```bash
Clone o repositório

# Instale as dependências do PHP
composer install

# Instale as dependências do Node.js
npm install
```

### 2. **Configuração do Ambiente**
```bash
# Crie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Gere as rotas do Ziggy
php artisan ziggy:generate

# Execute as migrations
php artisan migrate

# Execute os seeders para dados de teste
php artisan db:seed
```

### 3. **Build dos Assets**
```bash
# Compile os assets do frontend
npm run build
```

## **Executando a Aplicação**

### **Iniciar o Servidor**
```bash
php artisan serve
```

### **Acessar a Aplicação**
- **URL:** http://localhost:8000
- **Contatos:** http://localhost:8000/contacts

## **Verificação dos Testes**
```bash
# Execute todos os testes
php artisan test

# Execute testes específicos de contatos
php artisan test --filter ContactsTest
```

## **Funcionalidades Implementadas**

### **Backend (Laravel)**
- ✅ CRUD completo de contatos
- ✅ Validação de dados
- ✅ Testes unitários e de feature
- ✅ API RESTful
- ✅ Migrations e Seeders

### **Frontend (Vue3 + Inertia.js + TailwindCSS)**
- ✅ Interface moderna em português brasileiro
- ✅ Sistema de notificações elegante
- ✅ Modais de confirmação customizados
- ✅ Formulários com validação visual
- ✅ Design responsivo
- ✅ Componentes reutilizáveis

## **Dados de Teste**
O seeder criará **15 contatos de exemplo** automaticamente para facilitar os testes.