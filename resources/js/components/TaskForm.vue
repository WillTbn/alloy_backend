<script setup>
import { ref } from 'vue';


import { useTaskStore } from '@/stores/tasks';
import { storeToRefs } from 'pinia';
const taskStore = useTaskStore();
const { error, task } = storeToRefs(taskStore);
function submitTask() {
    if (!task.value.nome || !task.value.nome.trim()) {
        taskStore.setError('O nome da tarefa é obrigatório.');

        return;
    }
    if (!task.value.descricao || !task.value.descricao.trim()) {
         taskStore.setError('A descrição da tarefa é obrigatória.');
        return;
    }
    if (!task.value.data_limite) {
        taskStore.setError('A data limite é obrigatória.');
        return;
    }
    if(task.value.id) {
        // Se a tarefa já tem um ID, significa que é uma atualização
        taskStore.updateTask(task.value.id, task.value)
            .then(() => {
                task.value = {}; // Limpa o formulário após o envio
                taskStore.setError(null); // Reseta o erro
            })
            .catch((err) => {
                taskStore.setError(err.message || 'Erro ao atualizar tarefa.');
            });
        return;
    }
    taskStore.createTask(task.value)
        .then(() => {
            task.value = {}; // Limpa o formulário após o envio
            taskStore.setError(null); // Reseta o erro
        })
        .catch((err) => {
            taskStore.setError(err.message || 'Erro ao criar tarefa.');
        });
}
import ErrorMessage from './ErrorMessage.vue';

</script>

<template>
    <form @submit.prevent="submitTask" class="form" style="margin-top:1.5rem;">
        <div v-if="error" class="error-message">
            <ErrorMessage :message="error" />
        </div>
        <h2>Crie sua tarefa</h2>
        <div class="input-wrap">
            <label for="nome" class="form-fields">Nome da tarefa</label>
            <input
                v-model="task.nome"
                type="text"
                placeholder="Digite a tarefa"
                class="input"
                id="nome"

            />
        </div>
        <div class="input-wrap">
            <label for="description" class="form-fields">Descrição da tarefa</label>
            <textarea
                v-model="task.descricao"
                placeholder="Digite um descrição"
                class="input"
                id="description"
                rows="3"
            ></textarea>
        </div>
         <div class="input-wrap">
            <label for="data_limite" class="form-fields">Data limite</label>

            <input
                v-model="task.data_limite"
                type="date"
                placeholder="Digite a tarefa"
                class="input"
                id="data_limite"

            />
        </div>
        <div class="">
            <button type="submit" class="button">Adicionar</button>
        </div>


    </form>
</template>
<style scoped>
.form {
    flex-direction: column;
    gap: 1rem;
}
.input-wrap {
    display: flex;
    flex-direction: column;
}
</style>
