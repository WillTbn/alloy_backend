<script setup>
import { useCounterStore } from "@/stores/counter";
import { storeToRefs } from "pinia";

const counterStore = useCounterStore();
const { counter } = storeToRefs(counterStore);

const increment = () => {
    counterStore.increment();
};
</script>

<template>
    <div class="tasks">
        <p>Contador: {{ counter }}</p>
        <button @click="increment">Incrementar</button>
    </div>
</template>
