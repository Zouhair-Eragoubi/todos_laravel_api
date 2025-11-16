<template>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h1 class="auth-title">
          <i class="fas fa-tasks me-2"></i>
          Welcome Back
        </h1>
        <p class="auth-subtitle">Sign in to manage your todos</p>
      </div>

      <!-- Error Alert -->
      <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ errorMessage }}
        <button type="button" class="btn-close" @click="clearError" aria-label="Close"></button>
      </div>

      <form @submit.prevent="handleLogin" class="auth-form">
        <div class="mb-3">
          <label for="email" class="form-label">
            <i class="fas fa-envelope me-2"></i>Email
          </label>
          <input
            type="email"
            class="form-control"
            id="email"
            v-model="email"
            placeholder="Enter your email"
            required
            :disabled="loading"
          />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">
            <i class="fas fa-lock me-2"></i>Password
          </label>
          <input
            type="password"
            class="form-control"
            id="password"
            v-model="password"
            placeholder="Enter your password"
            required
            :disabled="loading"
          />
        </div>

        <button
          type="submit"
          class="btn btn-primary w-100 mb-3"
          :disabled="loading"
        >
          <span v-if="loading">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Signing in...
          </span>
          <span v-else>
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
          </span>
        </button>

        <div class="text-center">
          <p class="auth-link">
            Don't have an account?
            <router-link :to="{ name: 'register' }" class="link-primary">Sign Up</router-link>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/AuthStore';
import { storeToRefs } from 'pinia';

const router = useRouter();
const authStore = useAuthStore();
const { loading, errorMessage } = storeToRefs(authStore);

const email = ref('');
const password = ref('');

const handleLogin = async () => {
  const success = await authStore.login({
    email: email.value,
    password: password.value
  });

  if (success) {
    router.push({ name: 'home' });
  }
};

const clearError = () => {
  authStore.clearError();
};
</script>

<style scoped>
.auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.auth-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  padding: 40px;
  width: 100%;
  max-width: 450px;
  animation: fadeInUp 0.5s ease-out;
}

.auth-header {
  text-align: center;
  margin-bottom: 30px;
}

.auth-title {
  color: #667eea;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.auth-subtitle {
  color: #6c757d;
  font-size: 1rem;
  margin: 0;
}

.auth-form {
  margin-top: 20px;
}

.form-label {
  color: #495057;
  font-weight: 600;
  margin-bottom: 8px;
}

.form-control {
  border: 2px solid #e9ecef;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control:disabled {
  background-color: #f8f9fa;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 10px;
  padding: 12px;
  font-size: 1.1rem;
  font-weight: 600;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.auth-link {
  color: #6c757d;
  margin: 0;
}

.link-primary {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.2s ease;
}

.link-primary:hover {
  color: #764ba2;
  text-decoration: underline;
}

.alert {
  border: none;
  border-radius: 10px;
  margin-bottom: 20px;
}

.alert-danger {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
  color: white;
}

.alert-danger .btn-close {
  filter: brightness(0) invert(1);
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
