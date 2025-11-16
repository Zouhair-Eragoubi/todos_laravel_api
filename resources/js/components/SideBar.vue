<template>
    <div class="sidebar">
        <!-- User Section -->
        <div class="user-section mb-3">
            <div class="user-info">
                <i class="fas fa-user-circle user-icon"></i>
                <span class="user-name">{{ userName }}</span>
            </div>
            <button @click="handleLogout" class="btn btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </div>

        <hr>

        <category-title title="All Tasks" icon="fas fa-inbox"></category-title>

        <category-item title="All Tasks" icon="fas fa-inbox" ></category-item>
        <category-item v-for=" category in categories" :key="category.id" :title="category.name" icon="briefcase" :category="category.id"></category-item>

        <hr>

        <category-title title="Progress" icon="fas fa-chart-pie"></category-title>
        <chart-comp></chart-comp>
    </div>
</template>

<script setup>
import CategoryItem from '@/components/CategoryItem.vue'
import CategoryTitle from '@/components/CategoryTitle.vue';
import ChartComp from '@/components/ChartComp.vue'
import { useTodosStore } from '@/stores/TodosStore';
import { useAuthStore } from '@/stores/AuthStore';
import { useRouter } from 'vue-router';
import { computed } from 'vue';

const todosStore = useTodosStore();
const authStore = useAuthStore();
const router = useRouter();

const categories = computed(() => todosStore.allCategories);
const userName = computed(() => authStore.user?.name || 'User');

const handleLogout = async () => {
    await authStore.logout();
    router.push('/login');
};
</script>

<style>
.sidebar {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    height: fit-content;
    position: sticky;
    top: 20px;
}

.category-item {
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category-item:hover {
    background: #f0f0f0;
}

.category-item.active {
    background: var(--primary-gradient);
    color: white;
}

.user-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

.user-icon {
    font-size: 2rem;
    color: #667eea;
}

.user-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.btn-logout {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-logout:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
}
</style>
