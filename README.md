# Teste Técnico Alloy - To-Do List

## Descrição do Projeto

Este é um teste técnico para desenvolvedores da Alloy, consistindo na implementação de uma aplicação de lista de tarefas (To-Do List) utilizando **Laravel 12** como backend e **Vue.js 3** como frontend.

## Objetivo do Teste

O candidato deve implementar uma aplicação completa de gerenciamento de tarefas que demonstre conhecimentos em:

- Desenvolvimento de APIs RESTful com Laravel
- Frontend moderno com Vue.js e Pinia
- Gerenciamento de banco de dados SQLite
- Sistema de filas e jobs em Laravel
- Implementação de cache e invalidação
- Soft deletes
- Integração frontend/backend

## Stack Tecnológica

### Backend
- **Laravel 12.x** - Framework PHP
- **SQLite** - Banco de dados
- **PHP 8.2+** - Linguagem de programação

### Frontend
- **Vue.js 3.4** - Framework JavaScript
- **Pinia 2.1** - Gerenciamento de estado
- **Vite 6.3** - Build tool
- **TailwindCSS 4.0** - Framework CSS

### Ferramentas de Desenvolvimento
- **Laravel Vite Plugin** - Integração Vite/Laravel
- **Concurrently** - Execução paralela de comandos
- **Laravel Pail** - Log viewer
- **PHPUnit** - Testes unitários

## Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/     # Controllers da API
│   ├── Models/              # Models Eloquent
│   ├── Jobs/                # Jobs para processamento em fila
│   └── Services/            # Services para lógica de negócio
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/            # Seeders para dados iniciais
├── resources/
│   ├── js/
│   │   ├── components/      # Componentes Vue.js
│   │   ├── stores/         # Stores Pinia
│   │   └── services/       # Services para API
│   ├── css/                # Estilos CSS
│   └── views/              # Views Blade
├── routes/
│   ├── web.php             # Rotas web
│   └── api.php             # Rotas da API
└── public/webflow/         # Referência de design
```

## Funcionalidades Requeridas

### 1. Gerenciamento de Tarefas (CRUD)

#### Campos da Tarefa:
- `id` - Identificador único
- `nome` - Nome da tarefa (string, obrigatório)
- `descricao` - Descrição detalhada (text, opcional)
- `finalizado` - Status de conclusão (boolean, padrão: false)
- `data_limite` - Data limite para conclusão (datetime, opcional)
- `created_at` - Data de criação
- `updated_at` - Data da última atualização
- `deleted_at` - Data de exclusão (soft delete)

#### Operações:
- **Criar** nova tarefa
- **Listar** todas as tarefas (não excluídas)
- **Visualizar** tarefa específica
- **Editar** tarefa existente (clique para editar)
- **Marcar** como finalizada/não finalizada
- **Excluir** tarefa (soft delete)

### 2. Interface do Usuário

- Interface baseada no design disponível em `public/webflow/index.html`
- Lista de tarefas responsiva
- Modal para criação/edição de tarefas
- Botões de ação (editar, finalizar, excluir)
- Feedback visual para diferentes estados das tarefas

### 3. Sistema de Filas e Jobs

- **Job de Exclusão Automática**: Após uma tarefa ser marcada como finalizada, deve ser criado um job que será executado em 10 minutos para excluir definitivamente o registro
- Configuração de fila para processamento assíncrono

### 4. Sistema de Cache

- **Cache para Requests GET**: Implementar cache para listagem e visualização de tarefas
- **Invalidação de Cache**: Gerenciar invalidação automática quando dados são modificados (CREATE, UPDATE, DELETE)
- Tags de cache para invalidação granular

## Requisitos de Implementação

### Backend (Laravel)

1. **Model**
   ```php
   // Exemplo da estrutura esperada
   class Task extends Model
   {
       use SoftDeletes;
       
       protected $fillable = [
           'nome', 'descricao', 'finalizado', 'data_limite'
       ];
       
       protected $casts = [
           'finalizado' => 'boolean',
           'data_limite' => 'datetime',
       ];
   }
   ```

2. **Controller**
   - `TaskController` com métodos RESTful
   - Validação de dados de entrada
   - Respostas JSON padronizadas

3. **Routes**
   ```php
   // API Routes
   Route::apiResource('tasks', TaskController::class);
   Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle']);
   ```

4. **Migration**
   - Criação da tabela `tasks` com todos os campos necessários
   - Índices apropriados para performance

5. **Job**
   ```php
   class DeleteCompletedTask implements ShouldQueue
   {
       // Implementar lógica de exclusão definitiva
   }
   ```

6. **Cache**
   - Implementar cache com tags
   - Service ou Repository pattern para gerenciar cache

### Frontend (Vue.js)

1. **Componentes**
   - `TaskList.vue` - Lista de tarefas
   - `TaskItem.vue` - Item individual de tarefa
   - `TaskModal.vue` - Modal para criar/editar
   - `TaskForm.vue` - Formulário de tarefa

2. **Store (Pinia)**
   ```javascript
   // Exemplo de estrutura
   export const useTaskStore = defineStore('tasks', {
     state: () => ({
       tasks: [],
       loading: false,
     }),
     actions: {
       async fetchTasks() { /* ... */ },
       async createTask(task) { /* ... */ },
       async updateTask(id, task) { /* ... */ },
       async deleteTask(id) { /* ... */ },
       async toggleTask(id) { /* ... */ },
     }
   })
   ```

3. **Services**
   - `taskService.js` - Comunicação com API
   - Interceptors para tratamento de erros
   - Headers de autenticação se necessário

## Configuração e Execução

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite

### Instalação

1. **Clone e instale dependências:**
   ```bash
   composer install
   npm install
   ```

2. **Configuração do ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configuração do banco de dados (.env):**
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

4. **Execute as migrações:**
   ```bash
   php artisan migrate
   ```

5. **Execute o projeto:**
   ```bash
   composer run dev
   ```
   
   Ou alternativamente:
   ```bash
   # Terminal 1 - Laravel
   php artisan serve
   
   # Terminal 2 - Queue Worker
   php artisan queue:work
   
   # Terminal 3 - Vite
   npm run dev
   ```

### Scripts Disponíveis

- `composer run dev` - Executa todos os serviços simultaneamente
- `composer run test` - Executa os testes
- `npm run dev` - Desenvolvimento frontend
- `npm run build` - Build de produção

## Critérios de Avaliação

### Obrigatórios
- [x] CRUD completo de tarefas funcionando
- [x] Interface baseada no design fornecido
- [x] Sistema de filas implementado
- [x] Cache implementado com invalidação
- [x] Soft deletes funcionando
- [x] Código limpo e bem estruturado

### Diferenciais
- [x] Testes unitários/feature
- [ ] Tratamento de erros robusto
- [x] Validações frontend e backend -- somente validação no banckend
- [ ] Responsividade da interface
- [ ] Documentação de código
- [ ] Otimizações de performance

## Estrutura de Entrega

### Arquivos Principais a Implementar

1. **Backend:**
   - `app/Models/Task.php`
   - `app/Http/Controllers/TaskController.php`
   - `app/Jobs/DeleteCompletedTask.php`
   - `database/migrations/xxxx_create_tasks_table.php`
   - `routes/api.php` (adição das rotas)

2. **Frontend:**
   - `resources/js/stores/taskStore.js`
   - `resources/js/services/taskService.js`
   - `resources/js/components/TaskList.vue`
   - `resources/js/components/TaskModal.vue`
   - Atualização do `TasksContainer.vue`

### Documentação
- README.md atualizado com instruções específicas
- Comentários no código explicando lógicas complexas
- Documentação da API (opcional, mas valorizado)

## Dicas de Implementação

1. **Use o design fornecido** em `public/webflow/index.html` como referência visual
2. **Implemente primeiro o CRUD básico**, depois adicione cache e filas
3. **Valide dados** tanto no frontend quanto no backend
4. **Use transações** para operações que envolvem múltiplas tabelas
5. **Implemente loading states** para melhor UX
6. **Trate erros** de forma amigável ao usuário

## Melhorias 

1. Melhora o front dento um intendimento melhor das classes já disposta
2. validações no front


