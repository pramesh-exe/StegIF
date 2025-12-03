<script setup>
import TextTemplate from '../TextTemplate.vue';
import Button from '../Button.vue';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';
// Pictures
import q11 from '../../../img/test/q1-1.webp';
import q12 from '../../../img/test/q1-2.webp';
import q13 from '../../../img/test/q1-3.webp';
import q14 from '../../../img/test/q1-4.webp';
import q51 from '../../../img/test/q5-1.webp';
import q52 from '../../../img/test/q5-2.webp';
import q53 from '../../../img/test/q5-3.webp';
import q54 from '../../../img/test/q5-4.webp';
import diagram from '../../../img/test/diagram.svg';

const props = defineProps({
    experimentState: Number,
    participantId: String,
});

// Errors
const showError = ref(false);
const showServerError = ref(false);

// Answers
const question1 = ref([]); // checkbox
const question2 = ref([]); // checkbox
const question3 = ref([]); // checkbox
const question4 = ref(null); // radio button
const question5 = ref(null); // radio button
const question6 = ref([]); // checkbox
const question7 = ref([]); // checkbox
const question8 = ref(null); // radio button
const question9 = ref(null); // radio button

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

const emit = defineEmits(['update:experimentState', 'update:testScore']);

function next() {
    showServerError.value = false;
    showError.value = false;
    // Check if everything is filled in
    if (
        !question1.value.length
        || !question2.value.length
        || !question3.value.length
        || !question4.value
        || !question5.value
        || !question6.value.length
        || !question7.value.length
        || !question8.value
        || !question9.value
    ) {
        showError.value = true;
        return;
    }
    // Send results to server
    const test = {
        participant_id: props.participantId,
        question1: question1.value,
        question2: question2.value,
        question3: question3.value,
        question4: question4.value,
        question5: question5.value,
        question6: question6.value,
        question7: question7.value,
        question8: question8.value,
        question9: question9.value,
        time_since_start: timeSinceStart.value,
    }
    axios.post('/api/test/create', test)
        .then((response) => {
            console.log("The participant's knowledge test has been saved and " + response.data.score + " points were scored.");
            emit('update:testScore', response.data.score);
            // Then send has_finished=true to back end
            hasFinished();
        })
        .catch(error => {
            console.error('Error saving participant\'s knowledge test:', error.response?.data.message);
            // Show error to user and ask to try again
            showServerError.value = true;
        });
}

function hasFinished() {
    const participant = {
        id: props.participantId,
    }
    axios.post('/api/participant/finish', participant)
        .then((response) => {
            console.log("The participant has finished the experiment.");
            // Go to next experiment state
            emit('update:experimentState', 4);
        })
        .catch(error => {
            console.error('Error finishing the participant\'s data:', error.response?.data.message);
            showServerError.value = true;
        });
}
</script>

<template>
    <TextTemplate>
        <h2>Knowledge test</h2>
        <p>
            The following questions test whether the learning method you used was useful. There are two types of closed
            in this test questions:
        </p>
        <ol>
            <li>Checkboxes (square): multiple answers may be correct.</li>
            <li>Radio buttons (circle): only one option is correct.</li>
        </ol>
        <p>
            You will be reminded per question what answer is expected. Selecting a correct answer will increase your
            test score. Selecting a wrong answer will decrease your test score. Therefore, you can choose "I don't know"
            if you do not know the answer, which results into zero points for that question.
        </p>

        <!-- TODO: make components for questions -->
        <!-- Question 1: Steganography vs cryptography -->
        <h3>
            Which of the following pictures are an example of <u>steganography</u>? Select all that apply. Certain
            pictures may contain both steganography and cryptography.
        </h3>
        <div class="image-container">
            <label for="q1.1" :class="{ 'selected-image': question1.includes('1') }" @click.prevent
                @click="question1.includes('1') ? question1.splice(question1.indexOf('1'), 1) : question1.push('1')"
                style="min-height:320px;">
                <img :src="q11" />
                <p>
                    <b>Picture 1:</b> Some bits are adjusted in this image compared to the original one
                </p>
            </label>
            <label for="q1.2" :class="{ 'selected-image': question1.includes('2') }" @click.prevent
                @click="question1.includes('2') ? question1.splice(question1.indexOf('2'), 1) : question1.push('2')"
                style="min-height:320px;">
                <img :src="q12" />
                <p>
                    <b>Picture 2:</b> An unreadable text is going to be encoded into an image
                </p>
            </label>
            <label for="q1.3" :class="{ 'selected-image': question1.includes('3') }" @click.prevent
                @click="question1.includes('3') ? question1.splice(question1.indexOf('3'), 1) : question1.push('3')"
                style="min-height:320px;">
                <img :src="q13" />
                <p>
                    <b>Picture 3:</b> When holding a paper with certain holes on top of the letter, a secret message
                    appears
                </p>
            </label>
            <label for="q1.4" :class="{ 'selected-image': question1.includes('4') }" @click.prevent
                @click="question1.includes('4') ? question1.splice(question1.indexOf('4'), 1) : question1.push('4')"
                style="min-height:320px;">
                <img :src="q14" />
                <p>
                    <b>Picture 4:</b> Bob (in green) sends 'hello Alice' to Alice (in purple) over the internet
                </p>
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q1.1" value="1" v-model="question1" />
            <label for="q1.1">
                Picture 1
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q1.2" value="2" v-model="question1" />
            <label for="q1.2">
                Picture 2
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q1.3" value="3" v-model="question1" />
            <label for="q1.3">
                Picture 3
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q1.4" value="4" v-model="question1" />
            <label for="q1.4">
                Picture 4
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q1.0" value="0" v-model="question1" />
            <label for="q1.0">
                I don't know
            </label>
        </div>

        <!-- Question 2: Steganography vs cryptography -->
        <h3>
            Which of the following pictures are an example of <u>cryptography</u>? Select all that apply. Certain
            pictures may contain both steganography and cryptography.
        </h3>
        <div class="image-container">
            <label for="q2.1" :class="{ 'selected-image': question2.includes('1') }" @click.prevent
                @click="question2.includes('1') ? question2.splice(question2.indexOf('1'), 1) : question2.push('1')"
                style="min-height:320px;">
                <img :src="q11" />
                <p>
                    <b>Picture 1:</b> Some bits are adjusted in this image compared to the original one
                </p>
            </label>
            <label for="q2.2" :class="{ 'selected-image': question2.includes('2') }" @click.prevent
                @click="question2.includes('2') ? question2.splice(question2.indexOf('2'), 1) : question2.push('2')"
                style="min-height:320px;">
                <img :src="q12" />
                <p>
                    <b>Picture 2:</b> An unreadable text is going to be encoded into an image
                </p>
            </label>
            <label for="q2.3" :class="{ 'selected-image': question2.includes('3') }" @click.prevent
                @click="question2.includes('3') ? question2.splice(question2.indexOf('3'), 1) : question2.push('3')"
                style="min-height:320px;">
                <img :src="q13" />
                <p>
                    <b>Picture 3:</b> When holding a paper with certain holes on top of the letter, a secret message
                    appears
                </p>
            </label>
            <label for="q2.4" :class="{ 'selected-image': question2.includes('4') }" @click.prevent
                @click="question2.includes('4') ? question2.splice(question2.indexOf('4'), 1) : question2.push('4')"
                style="min-height:320px;">
                <img :src="q14" />
                <p>
                    <b>Picture 4:</b> Bob (in green) sends 'hello Alice' to Alice (in purple) over the internet
                </p>
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q2.1" value="1" v-model="question2" />
            <label for="q2.1">
                Picture 1
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q2.2" value="2" v-model="question2" />
            <label for="q2.2">
                Picture 2
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q2.3" value="3" v-model="question2" />
            <label for="q2.3">
                Picture 3
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q2.4" value="4" v-model="question2" />
            <label for="q2.4">
                Picture 4
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q2.0" value="0" v-model="question2" />
            <label for="q2.0">
                I don't know
            </label>
        </div>

        <!-- Question 3: Steganography preferred over cryptography -->
        <h3>In which of the following situation(s) is steganography preferred over cryptography? Select all that apply.
        </h3>
        <div class="form-item">
            <input type="checkbox" id="q3.1" value="1" v-model="question3" />
            <label for="q3.1">
                When trying to hack a system by sending an email with an attachment.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q3.2" value="2" v-model="question3" />
            <label for="q3.2">
                When filling in your password and sending it over the internet to the official website of the
                government.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q3.3" value="3" v-model="question3" />
            <label for="q3.3">
                When storing sensitive financial records in a database.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q3.4" value="4" v-model="question3" />
            <label for="q3.4">
                When communicating covertly in a country with strict censorship and surveillance.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q3.5" value="5" v-model="question3" />
            <label for="q3.5">
                When transmitting militairly orders over a secure channel.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q3.0" value="0" v-model="question3" />
            <label for="q3.0">
                I don't know.
            </label>
        </div>

        <!-- Question 4: Byte stream -->
        <h3>
            In which of the following byte streams is the letter 'm' (binary: 001101) hidden when the Least Significant
            Bit is used for steganography? Select one option.
        </h3>
        <div class="form-item">
            <input type="radio" id="q4.1" value="1" v-model="question4" />
            <label for="q4.1">
                11110010 10000001 00111101
                <br>
                11001001 10100101 00001101
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q4.2" value="2" v-model="question4" />
            <label for="q4.2">
                00001011 11111010 00011011
                <br>
                10110011 10001000 11100110
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q4.3" value="3" v-model="question4" />
            <label for="q4.3">
                00110101 11101001 11001101
                <br>
                00111101 10110111 01111010
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q4.4" value="4" v-model="question4" />
            <label for="q4.4">
                00101100 01011100 11111001
                <br>
                00011011 01011010 11011001
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q4.5" value="5" v-model="question4" />
            <label for="q4.5">
                00001101 11110110 00000010
                <br>
                10011011 00010000 00100100
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q4.0" value="0" v-model="question4" />
            <label for="q4.0">
                I don't know
            </label>
        </div>

        <!-- Question 5: Best hider -->
        <h3>
            Which of the following pictures can hide the most data with the use of steganography without visually seeing
            a difference? Select one option.
        </h3>
        <div class="image-container">
            <label for="q5.1" :class="{ 'selected-image': question5 === '1' }" @click.prevent @click="question5 = '1'">
                <img :src="q51" />
                <p>
                    <b>Picture 1</b>
                    <br>
                    Dimensions: 1400×1400
                    <br>
                    Type: JPEG
                </p>
            </label>
            <label for="q5.2" :class="{ 'selected-image': question5 === '2' }" @click.prevent @click="question5 = '2'">
                <img :src="q52" />
                <p>
                    <b>Picture 2</b>
                    <br>
                    Dimensions: 1400×1400
                    <br>
                    Type: JPEG
                </p>
            </label>
            <label for="q5.3" :class="{ 'selected-image': question5 === '3' }" @click.prevent @click="question5 = '3'">
                <img :src="q53" />
                <p>
                    <b>Picture 3</b>
                    <br>
                    Dimensions: 1400×1400
                    <br>
                    Type: JPEG
                </p>
            </label>
            <label for="q5.4" :class="{ 'selected-image': question5 === '4' }" @click.prevent @click="question5 = '4'">
                <img :src="q54" />
                <p>
                    <b>Picture 4</b>
                    <br>
                    Dimensions: 1400×1400
                    <br>
                    Type: JPEG
                </p>
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q5.1" value="1" v-model="question5" />
            <label for="q5.1">
                Picture 1
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q5.2" value="2" v-model="question5" />
            <label for="q5.2">
                Picture 2
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q5.3" value="3" v-model="question5" />
            <label for="q5.3">
                Picture 3
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q5.4" value="4" v-model="question5" />
            <label for="q5.4">
                Picture 4
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q5.0" value="0" v-model="question5" />
            <label for="q5.0">
                I don't know
            </label>
        </div>

        <!-- Question 6: Steganography usage -->
        <h3>
            What could steganography be used for? Select all that apply.
        </h3>
        <div class="form-item">
            <input type="checkbox" id="q6.1" value="1" v-model="question6" />
            <label for="q6.1">
                For getting inside a company's network with malware.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q6.2" value="2" v-model="question6" />
            <label for="q6.2">
                For conceiling instructions within videos shared on social media.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q6.3" value="3" v-model="question6" />
            <label for="q6.3">
                For verifying the authenticity of software using a digital signature.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q6.4" value="4" v-model="question6" />
            <label for="q6.4">
                For protecting passwords for safe storage.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q6.5" value="5" v-model="question6" />
            <label for="q6.5">
                For checking the validity of a communicated message.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q6.0" value="0" v-model="question6" />
            <label for="q6.0">
                I don't know.
            </label>
        </div>

        <!-- Question 7: Stego key -->
        <h3>
            What is the danger of not using a stego key? Select all that apply.
        </h3>
        <div class="form-item">
            <input type="checkbox" id="q7.1" value="1" v-model="question7" />
            <label for="q7.1">
                The cover file may become corrupted, which may lead to an unreadable message.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q7.2" value="2" v-model="question7" />
            <label for="q7.2">
                The encryption of the hidden message will be weakened.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q7.3" value="3" v-model="question7" />
            <label for="q7.3">
                The sender and receiver may not be able to verify each other's identity.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q7.4" value="4" v-model="question7" />
            <label for="q7.4">
                The hidden message may be easily extracted by anyone who suspects its existence.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q7.5" value="5" v-model="question7" />
            <label for="q7.5">
                The hidden message may be tampered with by someone who intercepted the transmission.
            </label>
        </div>
        <div class="form-item">
            <input type="checkbox" id="q7.0" value="0" v-model="question7" />
            <label for="q7.0">
                I don't know.
            </label>
        </div>

        <!-- Question 8: Diagram -->
        <h3>
            What should be put on the block with '???' in this diagram? Select one option.
        </h3>
        <div class="image-container">
            <img :src="diagram" style="width:550px;" />
        </div>
        <div class="form-item">
            <input type="radio" id="q8.1" value="1" v-model="question8" />
            <label for="q8.1">
                Cover
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q8.2" value="2" v-model="question8" />
            <label for="q8.2">
                StegWare
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q8.3" value="3" v-model="question8" />
            <label for="q8.3">
                Encryption
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q8.4" value="4" v-model="question8" />
            <label for="q8.4">
                StegAnalysis
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q8.5" value="5" v-model="question8" />
            <label for="q8.5">
                Identity
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q8.0" value="0" v-model="question8" />
            <label for="q8.0">
                I don't know
            </label>
        </div>

        <!-- Question 9: Stegware -->
        <h3>
            Please put the pseudocode of the StegWare in the right order. Select one option.
        </h3>
        <p>
            Pseudocode:
        </p>
        <ol type="A">
            <!-- A) -->
            <li>Select carrier file and malicious payload.</li>
            <!-- B) -->
            <li>Decode and extract hidden data from the carrier file (at victim's side).</li>
            <!-- C) -->
            <li>Embed malicious payload into a carrier file.</li>
            <!-- D) -->
            <li>Distribute the steganographic carrier file to the victim.</li>
            <!-- E) -->
            <li>Execute the malicious payload.</li>
        </ol>
        <br>
        <div class="form-item">
            <input type="radio" id="q9.1" value="1" v-model="question9" />
            <label for="q9.1">
                A, C, D, E, B.
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q9.2" value="2" v-model="question9" />
            <label for="q9.2">
                C, A, B, D, E.
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q9.3" value="3" v-model="question9" />
            <label for="q9.3">
                A, C, B, E, D.
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q9.4" value="4" v-model="question9" />
            <label for="q9.4">
                D, A, B, C, E.
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q9.5" value="5" v-model="question9" />
            <label for="q9.5">
                A, C, D, B, E.
            </label>
        </div>
        <div class="form-item">
            <input type="radio" id="q9.0" value="0" v-model="question9" />
            <label for="q9.0">
                I don't know.
            </label>
        </div>

        <!-- Error -->
        <p class="error" v-if="showError">
            * You have not yet filled in all the questions. Please check above whether you have missed something.
        </p>
        <p class="error" v-if="showServerError">
            * Something went wrong while saving your data. Please try again. If this issue keeps arising, please <a
                href="mailto:f.g.j.weijsenfeld@student.utwente.nl">contact me</a>.
        </p>

        <div class="button">
            <Button text="Next" :onClick="next" />
        </div>
    </TextTemplate>
</template>

<style scoped>
img {
    width: 330px;
    object-fit: contain;
    max-width: 100%;
}

img+p {
    width: 330px;
    max-width: 100%;
}

label {
    display: flex;
    flex-direction: column;
    justify-content: end;
}

.selected-image {
    background-color: var(--primary-light);
    border-radius: 10px;
}

.image-container {
    display: flex;
    flex-wrap: wrap;
    gap: var(--standard-padding);
    justify-content: space-evenly;
    margin-top: 5px;
    margin-bottom: var(--standard-padding);
    text-align: center;
    align-items: end;
}

.image-container>* {
    padding: 10px;
}
</style>
