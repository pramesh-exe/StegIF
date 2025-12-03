<script setup>
import socials from '../../data/socials.json';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
});

const url = socials[props.name].url
const icon = socials[props.name].icon

</script>

<template>
    <v-btn :icon="icon" variant="plain" :href="url" target="_blank" flat />
</template>

<style scoped>
.v-btn {
    opacity: 1;
}
</style>
