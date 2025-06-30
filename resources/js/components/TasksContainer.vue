<script setup>
import TaskModel from './TaskModel.vue';
import TaskList from './TaskList.vue';
import { useCounterStore } from "@/stores/counter";
import { storeToRefs } from "pinia";
import {useTaskStore} from '@/stores/tasks';
import { onMounted } from "vue";

const counterStore = useCounterStore();
const { counter } = storeToRefs(counterStore);
const tasksStore = useTaskStore();
const { tasks, modelCreate } = storeToRefs(tasksStore);
onMounted(() => {
    tasksStore.fetchTasks();
});
</script>

<template>
    <div class="tasks">
       <TaskList />


        <TaskModel v-if="modelCreate" />


    </div>
</template>
<style scoped>
/* Nenhum estilo extra necessário, pois está usando as classes do CSS fornecido */
.tasks{
    display: grid;
    align-items: center;
    justify-content: center;

    padding: 0.5rem;
    border-bottom: 1px solid #ccc;
}
</style>
