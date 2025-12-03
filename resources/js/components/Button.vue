<script setup>
const props = defineProps({
    onClick: Function,
    text: String,
    type: {
        type: Number,
        default: 1,
    }
});
</script>

<template>
    <div v-if="type === 1" class="type-1" @click="onClick">{{ text }}</div>
    <div v-if="type === 2" class="type-2" @click="onClick">{{ text }}</div>
</template>

<style scoped>
div {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: var(--standard-padding);
    padding-right: var(--standard-padding);
    width: 200px;
    min-width: fit-content;
    border-radius: var(--rounded-big);
    text-transform: uppercase;
    font-weight: 700;
    text-align: center;
    cursor: pointer;
}

.type-1 {
    background-color: var(--primary);
    color: var(--on-primary);
}

.type-2 {
    background-color: var(--secondary-container);
    color: var(--on-secondary-container);
}
</style>
