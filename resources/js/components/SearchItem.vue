<template>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    id="searchInput"
                    class="form-control"
                    placeholder="Search tasks..."
                    v-model="query"
                    @input="onSearch"
                />
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="sortSelect" v-model="sort" @change="onSort">
                <option value="date">Sort by Date</option>
                <option value="priority">Sort by Priority</option>
                <option value="category">Sort by Category</option>
                <option value="name">Sort by Name</option>
            </select>
        </div>
    </div>
</template>

<script setup>
import { ref} from 'vue';
import { useTodosStore } from '@/stores/TodosStore';

const todosStore = useTodosStore();

const query = ref('')
const sort = ref('date')

function onSearch() {
   todosStore.setSearchQuery(query.value);
}

function onSort() {
   todosStore.setSortBy(sort.value);
}

</script>

<style>
/* add styles if needed */
</style>
