<script setup>
import { ref } from 'vue';
import TaskForm from './TaskForm.vue';
import { useTaskStore } from '@/stores/tasks';
import { storeToRefs } from 'pinia';
const taskStore = useTaskStore();
const { modelCreate } = storeToRefs(taskStore);
</script>

<template>
    <div v-if="modelCreate" class="modal-overlay">
        <div class="modal-content">
            <button class="close-btn" @click="taskStore.setModelCreate(false)">×</button>
            <TaskForm />
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-content {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    min-width: 300px;
    position: relative;
}
.close-btn {
    position: absolute;
    top: 10px; right: 10px;
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}
</style>
