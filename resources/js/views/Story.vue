<template>
    <div class="story">
        <div class="filters">
            <button @click="getAll">All</button>
            <button @click="getChapter(1)">Chapter 1</button>
            <button @click="getChapter(2)">Chapter 2</button>
            <button @click="getChapter(3)">Chapter 3</button>
            <button @click="getChapter(4)">Chapter 4</button>
            <button @click="getChapter(5)">Chapter 5</button>
            <button @click="getChapter(7)">Chapter 6</button>
        </div>
        <DirectedGraph :nodes="filteredNodes" :links="filteredLinks" />
    </div>
</template>

<script setup>
import DirectedGraph from '../components/graphs/DirectedGraph.vue';

import jsonStory from '../../data/dialogue.json';
import { ref } from 'vue';

// Function to convert JSON to graph format
function convertDataToGraph(data) {
    const nodes = [];
    const nodeSet = new Set(); // Keep track of all node IDs
    const links = [];

    // Add nodes to the array and to the nodeSet
    data.forEach(item => {
        const nodeId = item.id.toString();
        nodes.push({ id: nodeId, content: item.content, character: item.character, choices: item.choices });
        nodeSet.add(nodeId);
    });

    // Add links and check if target nodes exist
    data.forEach(item => {
        const sourceId = item.id.toString();

        // Check for "next" links
        if (item.next) {
            const targetId = item.next.toString();
            if (nodeSet.has(targetId)) {
                links.push({ source: sourceId, target: targetId });
            } else {
                console.warn(`Missing node: ${targetId} referenced from node: ${sourceId}`);
            }
        }

        // Check for "choices" links
        if (item.choices) {
            item.choices.forEach(choice => {
                const targetId = choice.destination_id.toString();
                if (nodeSet.has(targetId)) {
                    links.push({ source: sourceId, target: targetId });
                } else {
                    console.warn(`Missing node: ${targetId} referenced from node: ${sourceId}`);
                }
            });
        }
    });

    return { nodes, links };
}

// Convert JSON into nodes and links
const { nodes, links } = convertDataToGraph(jsonStory);

// With filters
const filteredNodes = ref(nodes);
const filteredLinks = ref(links);

function getAll() {
    filteredNodes.value = nodes;
    filteredLinks.value = links;
}

function getChapter(chapter) {
    // Chapter 5 spreads over two numbers
    if (chapter === 5) {
        filteredNodes.value = nodes.filter((node) => node.id.startsWith('5') || node.id.startsWith('6'));
        filteredLinks.value = links.filter(
            (link) => (link.source.id.startsWith('5') || link.source.id.startsWith('6')) && (link.target.id.startsWith('5') || link.target.id.startsWith('6'))
        );
        return;
    }

    filteredNodes.value = nodes.filter((node) => node.id.startsWith(chapter));
    filteredLinks.value = links.filter(
        (link) => link.source.id.startsWith(chapter) && link.target.id.startsWith(chapter)
    );
}

</script>

<style scoped>
.story {
    background-color: #0f0f0f;
}

.filters {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 200px;
}

button {
    padding: 5px;
    border: 4px white solid;
    border-radius: 5px;
    color: white;
    background-color: #0f0f0fC0;
}
</style>
