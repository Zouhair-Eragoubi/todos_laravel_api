<template>
    <div class="todo-card">
                <div class="todo-header">
                        <div class="d-flex justify-content-between align-items-center">
                                <div>
                                        <h1 class="mb-0"><i class="fas fa-check-circle me-2"></i>Task Manager</h1>
                                        <p class="mb-0 mt-2">Organize your life efficiently</p>
                                </div>
                                <add-button></add-button>
                        </div>
                </div>
                
                <div class="p-4">
                        <!-- Search and Filter -->
                        <search-item></search-item>

                        <!-- Filter Buttons -->
                        <filter-buttons></filter-buttons>

                        <!-- Todo List -->
                        <todo-list></todo-list>
                </div>
        </div>
</template>

<script setup>
import SearchItem from '@/components/SearchItem.vue';
import FilterButtons from '@/components/FilterButtons.vue';
import TodoList from '@/components/TodoList.vue';
import AddButton from '@/components/AddButton.vue';
</script>

<style>
             
             
                .main-container {
                        max-width: 1200px;
                        margin: 0 auto;
                }
                
                
                
                .todo-card {
                        background: rgba(255, 255, 255, 0.95);
                        border-radius: 15px;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                }
                
                .todo-header {
                        background: var(--primary-gradient);
                        color: white;
                        padding: 25px;
                        border-radius: 15px 15px 0 0;
                }
                
                .category-badge {
                        display: inline-block;
                        padding: 5px 15px;
                        border-radius: 20px;
                        font-size: 0.85rem;
                        font-weight: 500;
                        margin-bottom: 10px;
                }
                
                .priority-high { background: #ff6b6b; color: white; }
                .priority-medium { background: #feca57; color: #333; }
                .priority-low { background: #48dbfb; color: white; }
                
                .todo-item {
                        transition: all 0.3s ease;
                        border-left: 4px solid #667eea;
                        position: relative;
                        overflow: hidden;
                }
                
                .todo-item:hover {
                        background-color: #f8f9fa;
                        transform: translateX(5px);
                }
                
                .todo-item.completed {
                        opacity: 0.6;
                        border-left-color: #28a745;
                }
                
                .todo-item.completed .todo-text {
                        text-decoration: line-through;
                }
                
                .todo-item.priority-high { border-left-color: #ff6b6b; }
                .todo-item.priority-medium { border-left-color: #feca57; }
                .todo-item.priority-low { border-left-color: #48dbfb; }
                
                .btn-add {
                        background: var(--primary-gradient);
                        border: none;
                        transition: transform 0.2s;
                }
                
                .btn-add:hover {
                        transform: scale(1.05);
                }
                
                .progress-ring {
                        width: 120px;
                        height: 120px;
                        margin: 0 auto;
                }
                
                .due-date {
                        font-size: 0.85rem;
                        color: #666;
                }
                
                .overdue {
                        color: #ff6b6b;
                        font-weight: bold;
                }
                
                .search-box {
                        position: relative;
                        margin-bottom: 20px;
                }
                
                .search-box input {
                        padding-left: 40px;
                }
                
                .search-box i {
                        position: absolute;
                        left: 15px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: #999;
                }
                
                .tag {
                        display: inline-block;
                        padding: 3px 10px;
                        background: #e9ecef;
                        border-radius: 12px;
                        font-size: 0.75rem;
                        margin-right: 5px;
                        color: #495057;
                }
                
                .modal-gradient {
                        background: var(--primary-gradient);
                        color: white;
                }
                
                .subtask {
                        padding: 8px;
                        background: #f8f9fa;
                        border-radius: 5px;
                        margin-top: 5px;
                        font-size: 0.9rem;
                }
</style>
