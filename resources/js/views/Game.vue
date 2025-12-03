<script setup>
import DialogBox from '../components/game/DialogBox.vue';
import nodes from '../../data/dialogue.json';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    experimentState: Number,
    participantId: String,
    saveResults: Boolean,
});

const emit = defineEmits(['update:experimentState']);

// Current gamenode
let node = ref(nodes[0]);

// Game states
let name = ref("Player");
let score = ref(0); // TODO implement score

// Time spent
const timeSinceStart = ref(0);
let interval = null;
onMounted(() => {
    interval = setInterval(() => {
        timeSinceStart.value += 1;
    }, 1000);
});

onBeforeUnmount(() => {
    clearInterval(interval);
});

// Binary search the nodes array
function binarySearchById(targetId) {
    let left = 0;
    let right = nodes.length - 1;

    while (left <= right) {
        const mid = Math.floor((left + right) / 2);
        const currentId = nodes[mid].id;

        if (currentId === targetId) {
            return nodes[mid];
        } else if (currentId < targetId) {
            left = mid + 1;
        } else {
            right = mid - 1;
        }
    }
    return null;
}

// Find next node
function handleTextOnClick() {
    saveNode(node.value.id, null);
    // Do not go to next node when game has ended
    if (node.value.id === 760) {
        // Go to next part in the experiment
        emit('update:experimentState', 2);
        return;
    }
    // Find next node value
    node.value = binarySearchById(node.value.next);
}

// Find node of choice
function handleQuestionOnClick(choice) {
    saveNode(node.value.id, choice.text);
    // Set name when asked for name
    if (node.value.id === 101) {
        name.value = choice.text;
    }
    // Go to next node
    node.value = binarySearchById(choice.destination_id);
}

function saveNode(id, choice) {
    // Only save node when in game of experiment
    if (!props.saveResults) {
        return;
    }

    // Send results to server
    const node = {
        participant_id: props.participantId,
        node: id,
        time_since_start: timeSinceStart.value,
    }
    if (choice) {
        node.choice = choice;
    }
    axios.post('/api/game/node/add', node)
        .then((response) => {
            // console.log("The game node has been saved.");
        })
        .catch(error => {
            console.error('Error saving the game node:', error.response?.data.message);
        });
}
</script>

<template>
    <!-- Type TEXT -->
    <div v-if="node.type === 'TEXT'">
        <DialogBox :node="node" :onClick="handleTextOnClick" :name="name" />
    </div>
    <!-- Type QUESTION -->
    <div v-if="node.type === 'QUESTION'">
        <DialogBox :node="node" :onClick="handleQuestionOnClick" :name="name" />
    </div>
</template>
