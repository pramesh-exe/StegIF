<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { updateContainerSize } from "./resize.js";

const props = defineProps({
    node: Object,
    name: String,
    onClick: Function,
});

const hasRead = ref(false);

// Styling
const backgroundContainer = ref(null);
const backgroundImage = ref(null);
const fontSizeText = ref("28px");
const fontSizeChoice = ref("20px");

// Function used to handle the click event
function handleOnClick() {
    if (props.node.type === "TEXT") {
        props.onClick();
    }
    if (props.node.type === "QUESTION") {
        hasRead.value = true;
    }
}

// Function used to handle answer choice selection
function handleOnClickAnswer(choice) {
    hasRead.value = false;
    props.onClick(choice);
}

// Function to replace placeholders in text
function replacePlaceholders(template, values) {
    return template.replace(/\$\{(\w+)\}/g, (match, key) => {
        return key in values ? values[key] : match;
    });
}

// Returns the text shown to the user with replaced placeholders
function getContent() {
    return replacePlaceholders(props.node.content, { name: props.name });
}

// Image path for the background
function getBackgroundImage() {
    return `/backgrounds/${props.node.background}.jpeg`;
}

// Image path for the character
function getCharacterImage() {
    return `/characters/${props.node.character}/${props.node.emotion}.webp`;
}

// Image path for the text cloud
function getTextCloudImage() {
    return `/characters/${props.node.character}/text.webp`;
}

// Chapter number
function getChapterNumber() {
    const startWith = String(props.node.id).charAt(0);
    if (startWith === "1") {
        return "1: The Invisible Ink";
    }
    if (startWith === "2") {
        return "2: Paint by Numbers";
    }
    if (startWith === "3") {
        return "3: The Bad Guys";
    }
    if (startWith === "4") {
        return "4: The False Alarm & the Trap";
    }
    if (startWith === "5") {
        return "5: Washing the Data";
    }
    if (startWith === "6") {
        return "6: Bonus";
    }
    return startWith;
}

// Update the background and font sizes dynamically
function updateSizes() {
    updateContainerSize(
        backgroundImage,
        backgroundContainer,
        fontSizeText,
        fontSizeChoice
    );
}

// Return fallback image if image not found
function handleBackgroundImageError(event) {
    event.target.src = "/backgrounds/fallback.png";
}

// Return fallback image if image not found
function handleCharacterImageError(event) {
    event.target.src = "/characters/fallback.webp";
}

// Return fallback image if image not found
function handleTextCloudImageError(event) {
    event.target.src = "/characters/fallback-text.webp";
}

onMounted(() => {
    window.addEventListener("resize", updateSizes);
    updateSizes();
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", updateSizes);
});
</script>

<template>
    <div class="click noselect" @click="handleOnClick">
        <div ref="backgroundContainer" class="background-container">
            <!-- Background -->
            <img
                ref="backgroundImage"
                class="background-image"
                :src="getBackgroundImage()"
                @load="updateSizes"
                @error="handleBackgroundImageError"
            />
            <!-- Character -->
            <img
                class="character-image"
                :src="getCharacterImage()"
                @error="handleCharacterImageError"
            />
            <!-- Text Cloud -->
            <img
                v-if="props.node.id !== 760"
                class="character-image"
                :src="getTextCloudImage()"
                @error="handleTextCloudImageError"
            />
            <!-- Story Info -->
            <div class="story-info">
                <b>Chapter: {{ getChapterNumber() }}</b>
                <br />
                <i class="fa-solid fa-location-dot" />&nbsp;{{
                    props.node.location
                }}
            </div>

            <!-- Type TEXT & Type QUESTION -->
            <p
                v-if="props.node.id !== 760"
                :class="
                    props.node.character === 'player' ? 'text-player' : 'text'
                "
                :style="{ fontSize: fontSizeText }"
            >
                {{ getContent() }}
            </p>
            <!-- Type QUESTION -->
            <div
                v-if="hasRead"
                class="choices"
                :style="
                    node.choices.length > 5
                        ? { gridTemplateColumns: '1fr 1fr' }
                        : {}
                "
            >
                <div />
                <div
                    v-for="choice in node.choices"
                    :key="choice.text"
                    class="choice"
                    :style="{ fontSize: fontSizeChoice }"
                    @click="handleOnClickAnswer(choice)"
                >
                    {{ choice.text }}
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.noselect {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.click {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background-color: black;
    overflow: hidden;
    display: flex;
    justify-items: center;
}

.background-container {
    position: relative;
    margin: auto;
    display: inline-block;
}

.background-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.character-image {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    bottom: 0;
}

.text {
    color: black;
    position: absolute;
    top: 74.5%;
    left: 33%;
    display: block;
    width: 54%;
}

.text-player {
    color: white;
    position: absolute;
    top: 74.5%;
    left: 17%;
    display: block;
    width: 52%;
}

.choices {
    display: grid;
    position: absolute;
    bottom: 38%;
    right: 5%;
    gap: 10px;
    max-width: 40%;
    min-width: 15%;
}

.choice {
    min-width: fit-content;
    width: 100%;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    border: 0.2vh white solid;
    border-radius: 10px;
    color: white;
    background-color: #00000090;
    cursor: pointer;
    text-align: right;
}

.story-info {
    min-width: fit-content;
    position: absolute;
    top: 10px;
    right: 10px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    border: 0.2vh white solid;
    border-radius: 10px;
    color: white;
    background-color: #00000090;
}
</style>
