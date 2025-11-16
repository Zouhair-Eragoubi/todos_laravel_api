<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script setup>
</script>

<style>
  :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
      --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
      --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  }

  body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 20px 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .alert {
      animation: slideDown 0.3s ease-out;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border-radius: 10px;
  }

  .alert-danger {
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      color: white;
  }

  .alert-danger .btn-close {
      filter: brightness(0) invert(1);
  }

  @keyframes slideDown {
      from {
          opacity: 0;
          transform: translateY(-20px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }
</style>
