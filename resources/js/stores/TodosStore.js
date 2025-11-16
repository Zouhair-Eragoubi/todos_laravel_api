import { defineStore } from 'pinia'

// Helper function to get auth headers
const getAuthHeaders = () => {
  const token = localStorage.getItem('token');
  return {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...(token && { 'Authorization': `Bearer ${token}` })
  };
};

export const useTodosStore = defineStore('todos', {
  state: () => ({
    todos: [],
    categories: [],
    currentCategory: undefined,
    completed: undefined,
    priority: undefined,
    sortBy: 'date',
    searchQuery: '',
    errors: [],
    loading: false,
    errorMessage: ''
  }),
  getters: {
    allTodos: (state) => {
      let filteredTodos = state.todos.filter(todo => {
        const categoryMatch = state.currentCategory === undefined || 
          todo.category_id === state.currentCategory;
        const completionMatch = state.completed === undefined || 
          todo.completed === state.completed;
        const priorityMatch = state.priority === undefined || 
          todo.priority.toLowerCase() === state.priority.toLowerCase();
        const searchMatch = state.searchQuery === '' || 
          (todo.name.toLowerCase().includes(state.searchQuery.toLowerCase()) ||
           todo.desc.toLowerCase().includes(state.searchQuery.toLowerCase()));
        
        return categoryMatch && completionMatch && priorityMatch && searchMatch;
      });

      // Sort todos based on sortBy value
      switch (state.sortBy) {
        case 'date':
          filteredTodos.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
          break;
        case 'priority': {
          const priorityOrder = { 'High': 3, 'Medium': 2, 'Low': 1 };
          filteredTodos.sort((a, b) => priorityOrder[b.priority] - priorityOrder[a.priority]);
          break;
        }
        case 'title':
          filteredTodos.sort((a, b) => a.name.localeCompare(b.name));
          break;
      }

      return filteredTodos;
    },
    allCategories: (state) => {
      return state.categories;
    },
    currentCategoryCount: (state) => {
      return state.todos.length;
    },
    getCategoryTodosCount: (state) => (category) => {
      if (category === undefined) {
        return state.todos.length;
      }
      return state.todos.filter(todo => todo.category_id == category).length;
    },
    getCompletedTodosCount: (state) => (completed) => {
      if (completed === undefined) {
        return state.todos.length;
      }
      return state.todos.filter(todo => todo.completed === completed).length;
    },
    getCurrentCategory: (state) => {
      return state.currentCategory;
    },
    getCurrentPriority: (state) => {
      return state.priority;
    },
    getCompletionStatus: (state) => {
      return state.completed;
    }
  },
  actions: {
    async addTodo(todo) {
      try {
        this.loading = true;
        this.errorMessage = '';

        const response = await fetch('/api/todos/create', {
          method: 'POST',
          headers: getAuthHeaders(),
          body: JSON.stringify(todo)
        });

        const data = await response.json();

        if (data.errors) {
          this.errors = data.errors;
          this.errorMessage = 'Failed to create task. Please check all fields.';
          return false;
        }

        if (!response.ok) {
          throw new Error(data.message || 'Failed to create task');
        }

        this.todos.push(data.todo);
        this.errors = [];
        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Network error. Please try again.';
        return false;
      } finally {
        this.loading = false;
      }
    },
    setCategoryFilter(category) {
      this.currentCategory = category;
    },
    setCompletionFilter(completed) {
      this.completed = completed;
    },
    setPriorityFilter(priority) {
      this.priority = priority;
    },
    setSearchQuery(query) {
      this.searchQuery = query;
    },
    setSortBy(sortBy) {
      this.sortBy = sortBy;
    },
    removeTodo(todo) {
      this.todos = this.todos.filter(t => t !== todo);
    },
    async toggleTodoCompletion(todoId) {
      try {
        const id = typeof todoId === 'string' ? Number(todoId) : todoId;

        const response = await fetch(`/api/todos/toggle-completion/${id}`, {
          method: 'PATCH',
          headers: getAuthHeaders()
        });

        const data = await response.json();

        if (data.error || !response.ok) {
          throw new Error(data.error || 'Failed to toggle task completion');
        }

        this.todos = this.todos.map(t => {
          if (t.id === id) {
            return { ...t, completed: !t.completed, updatedAt: new Date().toISOString() };
          }
          return t;
        });

        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Failed to update task';
        return false;
      }
    },
    async deleteTodo(todoId) {
      try {
        const response = await fetch(`/api/todos/delete/${todoId}`, {
          method: 'DELETE',
          headers: getAuthHeaders()
        });

        if (!response.ok) {
          const data = await response.json();
          throw new Error(data.message || 'Failed to delete task');
        }

        this.todos = this.todos.filter(t => t.id !== todoId);
        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Failed to delete task';
        return false;
      }
    },
    async updateTodo(todoId, todo) {
      try {
        this.loading = true;
        this.errorMessage = '';

        const response = await fetch(`/api/todos/update/${todoId}`, {
          method: 'PUT',
          headers: getAuthHeaders(),
          body: JSON.stringify(todo)
        });

        const data = await response.json();

        if (data.errors) {
          this.errors = data.errors;
          this.errorMessage = 'Failed to update task. Please check all fields.';
          return false;
        }
        if (!response.ok) {
          throw new Error(data.message || 'Failed to update task');
        }

        // Handle different response structures
        const updatedTodo = data.todo || data;

        // Convert todoId to number for comparison
        const numericTodoId = typeof todoId === 'string' ? Number(todoId) : todoId;

        const updatedTodos = this.todos.map(t => {
          const numericTaskId = typeof t.id === 'string' ? Number(t.id) : t.id;
          if (numericTaskId === numericTodoId) {
            return updatedTodo;
          }
          return t;
        });

        // Force reactivity by replacing the entire array
        this.todos = [...updatedTodos];
        this.errors = [];
        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Network error. Please try again.';
        return false;
      } finally {
        this.loading = false;
      }
    },
    resetFilters() {
      this.completed = undefined;
      this.priority = undefined;
    },
    async loadTodos() {
      try {
        this.loading = true;
        this.errorMessage = '';

        const response = await fetch('/api/todos', {
          method: 'GET',
          headers: getAuthHeaders()
        });

        if (!response.ok) {
          throw new Error('Failed to load tasks');
        }

        const data = await response.json();
        this.todos = data.todos;
        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Failed to load tasks';
        return false;
      } finally {
        this.loading = false;
      }
    },
    async loadCategories() {
      try {
        const response = await fetch('/api/categories', {
          method: 'GET',
          headers: getAuthHeaders()
        });

        if (!response.ok) {
          throw new Error('Failed to load categories');
        }

        const data = await response.json();
        this.categories = data.categories;
        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Failed to load categories';
        return false;
      }
    }
  }
});