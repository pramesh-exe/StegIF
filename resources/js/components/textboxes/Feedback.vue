<script setup>
import TextTemplate from '../TextTemplate.vue';
import Button from '../Button.vue';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    experimentState: Number,
    participantId: String,
    testScore: Number,
    inGameGroup: Boolean,
});

// Answers
const gameImprovements = ref(null);
const textImprovements = ref(null);
const otherImprovements = ref(null);

// Communication
const showServerError = ref(false);
const emit = defineEmits(['update:experimentState']);

function next() {
    showServerError.value = false;
    const answer = {
        participant_id: props.participantId,
    };
    if (gameImprovements.value) {
        answer.game_improvements = gameImprovements.value;
    }
    if (textImprovements.value) {
        answer.text_improvements = textImprovements.value;
    }
    if (otherImprovements.value) {
        answer.other_improvements = otherImprovements.value;
    }
    axios.post('/api/feedback/create', answer)
        .then((response) => {
            console.log("The feedback has been saved.");
            emit('update:experimentState', 5);
        })
        .catch(error => {
            showServerError.value = true;
            console.error('Error saving the feedback:', error.response?.data.message);
        });
}

function grade() {
    const score = props.testScore < 0 ? 0 : props.testScore;
    const grade = score / 54 * 9 + 1;
    return Math.round(grade * 100) / 100;
}


</script>

<template>
    <TextTemplate>
        <h2>Feedback</h2>
        <p>
            You scored {{ props.testScore }} out of 54 points on the test (which is similar to a {{ grade() }} on a
            Dutch exam scale from 1-10)!
        </p>

        <div v-if="inGameGroup">
            <h3>Do you have any improvements for the game?</h3>
            <textarea type="text" v-model="gameImprovements" />
        </div>

        <div v-else>
            <h3>Do you have any improvements for the text you read?</h3>
            <textarea type="text" v-model="textImprovements" />
        </div>

        <div>
            <h3>Anything else that you would like to share?</h3>
            <textarea type="text" v-model="otherImprovements" />
        </div>

        <p class="error" v-if="showServerError">
            * Something went wrong while saving your data. Please try again. If this issue keeps arising, please
            <a href="mailto:f.g.j.weijsenfeld@student.utwente.nl">contact me</a>.
        </p>

        <div class="button">
            <Button text="Next" :onClick="next" />
        </div>
    </TextTemplate>
</template>

<style scoped>
p+div,
div+div {
    margin-top: var(--standard-padding);
}

h3+textarea {
    margin-top: 10px;
}

p {
    font-size: larger;
}
</style>
