# **Sistema Agropecuário**

Este projeto é um sistema de gestão agropecuária desenvolvido utilizando **Laravel** no back-end e **Vue.js com Inertia.js** no front-end.

O sistema permite o gerenciamento completo de **produtores rurais**, **propriedades**, **rebanhos** e **unidades de produção**, além de oferecer **relatórios detalhados** e **exportação de dados**.

---

## **Funcionalidades Implementadas**

* **CRUD Completo:** Gestão total para Produtores, Propriedades, Rebanhos e Unidades de Produção.  
* **Dashboard:** Página inicial com gráficos e indicadores de desempenho (KPIs) sobre os dados do sistema.  
* **Listagens Avançadas:** Todas as listagens possuem paginação e filtros dinâmicos.  
* **Relatórios:** Secção dedicada com dados agregados e estatísticas.  
* **Exportação de Dados:** Exportação de relatórios em **Excel (.xlsx)** e **PDF**.  
* **Testes Automatizados:** Testes de back-end com **PHPUnit** e de front-end com **Vitest**.  
* **Database Seeding:** População automática da base de dados com dados de exemplo realistas.  

---

## **Tecnologias Utilizadas**

**Back-end:** Laravel 12, PHP 8.2, PostgreSQL  
**Front-end:** Vue.js 3, Inertia.js, Vite  
**UI:** PrimeVue e Tailwind CSS  
**Exportação:** spatie/simple-excel (Excel) e barryvdh/laravel-dompdf (PDF)  
**Testes:** PHPUnit (back-end), Vitest (front-end)

---

## **Instalação e Execução**

### **Pré-requisitos**

- PHP ≥ 8.2  
- Composer  
- Node.js & NPM  
- PostgreSQL  

### **Passos para Instalação**

1. **Clonar o repositório:**
   ```bash
   git clone https://github.com/anselmoparente/Sistema-Agropecuario.git
   cd Sistema-Agropecuario
   ```

2. **Instalar dependências do PHP:**
   ```bash
   composer install
   ```

3. **Instalar dependências do Node.js:**
   ```bash
   npm install
   ```

4. **Configurar o ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Depois, edite o arquivo `.env` e configure as credenciais do PostgreSQL:
   ```bash
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=sua_db
   DB_USERNAME=seu_user
   DB_PASSWORD=sua_senha
   ```

5. **Criar e popular o banco de dados:**
   ```bash
   php artisan migrate:fresh --seed
   ```

---

## **Executando o Projeto**

1. **Iniciar o servidor de desenvolvimento do front-end:**
   ```bash
   npm run dev
   ```

2. **Iniciar o servidor do Laravel (back-end):**
   ```bash
   php artisan serve
   ```

Após esses passos, o sistema estará disponível em:  
**http://127.0.0.1:8000**

**Credenciais de Acesso Padrão:**

- **Email:** admin@example.com  
- **Senha:** password  

---

## **Como Testar o Sistema**

### **1. Testes Automatizados**

Antes de rodar os testes, é necessário configurar um ambiente isolado de testes para o Laravel.

#### **Configurar o Ambiente de Testes**

1. **Criar o arquivo `.env.testing`:**
   ```bash
   cp .env .env.testing
   ```

2. **Editar o `.env.testing` e configurar o banco de dados de teste:**
   ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE=:memory:
   ```

3. **Garantir que a chave da aplicação (`APP_KEY`) seja a mesma do `.env` principal.**  
   Se ela não for copiada automaticamente, copie manualmente o valor:
   ```bash
   APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
   ```

#### **Executar os Testes de Back-end (PHPUnit)**

Para rodar todos os testes do Laravel:
```bash
php artisan test
```

Para executar com relatório de cobertura:
```bash
php artisan test --coverage
```

#### **Executar os Testes de Front-end (Vitest)**

Rode os testes dos componentes Vue:
```bash
npm run test
```

---

### **2. Testes Manuais**

Após executar o projeto (Laravel + Vite):

1. Acesse `http://127.0.0.1:8000`  
2. Faça login com:
   ```
   Email: admin@example.com
   Senha: password
   ```
3. Explore as seções:
   - **Produtores** → CRUD completo  
   - **Propriedades** → Associação com produtores  
   - **Rebanhos** → Controle por propriedade  
   - **Relatórios** → Geração de relatórios e exportação (Excel/PDF)  
4. Teste filtros, paginação e geração de relatórios.  
5. Verifique o dashboard inicial com KPIs e gráficos.  

---

## **Arquitetura e Qualidade**

- **Monólito Moderno:** Laravel + Vue + Inertia.js em uma única base, simulando SPA sem API REST separada.  
- **Boas Práticas:** Controllers enxutos, componentes Vue modulares e testes automatizados.  
- **UX Responsiva:** Interface desenvolvida com PrimeVue e Tailwind CSS.  
- **Performance:** Filtros com debounce e carregamento otimizado de dados.  

---

## **Exemplos de Relatórios**

### **1. Relatório de Propriedades (Excel)**
- **Descrição:** Gera um `.xlsx` com todas as propriedades registradas.  
- **Colunas:** Nome da Propriedade, Produtor, Município, UF, Inscrição Estadual, Área Total (ha).  
- [Exemplo visual](https://imgur.com/a/KFqTyG6)

### **2. Relatório Geral de Rebanhos (PDF)**
- **Descrição:** Lista todos os rebanhos agrupados por produtor.  
- **Conteúdo:** Tabelas detalhadas por propriedade, espécie, quantidade e finalidade.  
- [Exemplo visual](https://imgur.com/a/I817ZwP)

