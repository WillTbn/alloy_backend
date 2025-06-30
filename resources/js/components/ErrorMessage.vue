<script setup>
defineProps({
    message: {
        type: String,
        required: true
    }
});
import { defineComponent } from 'vue';
defineComponent({
    name: 'ErrorMessage'
})
</script>

<template>
    <div class="error-message">
        {{ message }}
    </div>
</template>

<style scoped>
/* Você pode adicionar estilos extras aqui se quiser */
</style>
