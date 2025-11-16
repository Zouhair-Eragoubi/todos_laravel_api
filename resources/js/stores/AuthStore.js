import { defineStore } from 'pinia'
import { useTodosStore } from '@stores/TodosStore';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    loading: false,
    errorMessage: ''
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user
  },
  actions: {
    async login(credentials) {
      try {
        this.loading = true;
        this.errorMessage = '';

        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(credentials)
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.message || 'Login failed');
        }

        this.token = data.access_token;
        this.user = data.user;
        localStorage.setItem('token', data.access_token);

        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Login failed. Please try again.';
        return false;
      } finally {
        this.loading = false;
      }
    },

    async register(userData) {
      try {
        this.loading = true;
        this.errorMessage = '';

        const response = await fetch('/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(userData)
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.message || 'Registration failed');
        }

        this.token = data.access_token;
        this.user = data.user;
        localStorage.setItem('token', data.access_token);

        return true;
      } catch (error) {
        this.errorMessage = error.message || 'Registration failed. Please try again.';
        return false;
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      try {
        if (this.token) {
          await fetch('/api/logout', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${this.token}`
            }
          });
        }
      } catch (error) {
        // Silently handle logout errors
      } finally{
        this.token = null;
        this.user = null;
        localStorage.removeItem('token');

        // Clear todos store data
        const todosStore = useTodosStore();
        todosStore.todos = [];
        todosStore.categories = [];
      }
    },

    async checkAuth() {
      if (!this.token) {
        return false;
      }

      try {
        const response = await fetch('/api/user', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${this.token}`
          }
        });

        if (!response.ok) {
          this.logout();
          return false;
        }

        const data = await response.json();
        this.user = data;
        return true;
      } catch (error) {
        this.logout();
        return false;
      }
    },

    clearError() {
      this.errorMessage = '';
    }
  }
});
