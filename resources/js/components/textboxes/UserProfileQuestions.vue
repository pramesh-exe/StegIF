<script setup>
import TextTemplate from '../TextTemplate.vue';
import Button from '../Button.vue';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    inGameGroup: Boolean,
    participantId: String,
    experimentState: Number,
});

const showError = ref(false);
const showServerError = ref(false);
const emit = defineEmits(['update:experimentState']);

// Answers
const age = ref(null);
const expertise = ref(null);
const education = ref(null);
const gaming = ref(null);
const cybersecurity = ref(null);
const steganography = ref(null);
const stegoExplanation = ref(null);

// Send result and go to next
function next() {
    showServerError.value = false;
    showError.value = false;
    // Check if everything is filled in
    if (
        age.value === null
        || !expertise.value
        || !education.value
        || !gaming.value
        || !cybersecurity.value
        || !steganography.value
        || !stegoExplanation.value
    ) {
        showError.value = true;
        return;
    }
    // Send results to server
    const profile = {
        participant_id: props.participantId,
        age: age.value,
        main_expertise: expertise.value,
        education: education.value,
        gaming_experience: gaming.value,
        cybersecurity: cybersecurity.value,
        steganography: steganography.value,
        stego_explanation: stegoExplanation.value,
    }
    axios.post('/api/profile/create', profile)
        .then((response) => {
            console.log("The participant's profile has been saved.");
            // Launch fullscreen for browsers that support it
            launchFullScreen(document.documentElement);
            // Go to next part in the experiment
            emit('update:experimentState', 1);
        })
        .catch(error => {
            console.error('Error saving participant\'s profile:', error.response?.data.message);
            // Show error to user and ask to try again
            showServerError.value = true;
        });
}

function launchFullScreen(element) {
    if (element.requestFullScreen) {
        element.requestFullScreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
    }
}
</script>

<template>
    <TextTemplate>
        <h2>Questions before your task</h2>
        <p class="warning">
            <b>
                IMPORTANT NOTICE: Please do not refresh your browser at any time during this
                experiment. Also, do not use the 'back' and 'forward' buttons in your browser. Both will completely
                reset what you have done, and therefore your actions will not be recorded.
            </b>
        </p>
        <p v-if="inGameGroup">
            You have been given the game task. Please answer the questions below and then press 'NEXT'. The game
            about steganography will then start.
        </p>
        <p v-else>
            You have been given the reading task. Please answer the questions below and then press 'NEXT'. You can then
            learn about steganography.
        </p>

        <div class="form">
            <!-- Question 1: Age-->
            <div class="form-item column">
                <h3>What is your age?</h3>
                <input id="age" v-model.trim.number="age" type="text" />
            </div>

            <!-- Question 2: Main expertise -->
            <h3>In what field is your main expertise?</h3>
            <div class="form-item">
                <input type="radio" id="Humanities and social sciences" value="Humanities and social sciences"
                    v-model="expertise" />
                <label for="Humanities and social sciences">
                    Humanities and social sciences<br />
                    <div class="example">
                        (e.g. history, linguistics, philosophy, arts, religion, economics, geography, culture, politics,
                        psychology, sociology)
                    </div>
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="Natural sciences" value="Natural sciences" v-model="expertise" />
                <label for="Natural sciences">
                    Natural sciences<br />
                    <div class="example">
                        (e.g. biology, chemistry, earth sciences, physics, space sciences)
                    </div>
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="Formal sciences" value="Formal sciences" v-model="expertise" />
                <label for="Formal sciences">
                    Formal sciences<br />
                    <div class="example">
                        (e.g. computer sciences, logic, mathematics, systems science)
                    </div>
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="Professions and applied sciences" value="Professions and applied sciences"
                    v-model="expertise" />
                <label for="Professions and applied sciences">
                    Professions and applied sciences<br />
                    <div class="example">
                        (e.g. engineering and technology, medicine and health, environmental studies, journalism and
                        media, law, social work, transportation, education, business, architecture and design,
                        agriculture)
                    </div>
                </label>
            </div>

            <!-- Question 3: Education level -->
            <h3>What is your education level?</h3>
            <div class="form-item">
                <input type="radio" id="WO" value="WO" v-model="education" />
                <label for="WO">
                    University (WO)
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="HBO" value="HBO" v-model="education" />
                <label for="HBO">
                    University of Applied Sciences (HBO)
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="MBO" value="MBO" v-model="education" />
                <label for="MBO">
                    College (MBO)
                </label>
            </div>

            <!-- Question 4: Gaming level -->
            <h3>How much experience do you have in playing games?</h3>
            <div class="form-item">
                <input type="radio" id="None" value="None" v-model="gaming" />
                <label for="None">I have never played a game</label>
            </div>
            <div class="form-item">
                <input type="radio" id="A bit" value="A bit" v-model="gaming" />
                <label for="A bit">I have watched others play, but I never played a game myself</label>
            </div>
            <div class="form-item">
                <input type="radio" id="Average" value="Average" v-model="gaming" />
                <label for="Average">I play a game occasionaly, but not regularly</label>
            </div>
            <div class="form-item">
                <input type="radio" id="More than average" value="More than average" v-model="gaming" />
                <label for="More than average">I play a game at least once a month</label>
            </div>
            <div class="form-item">
                <input type="radio" id="A lot" value="A lot" v-model="gaming" />
                <label for="A lot">I play a game weekly or more frequently</label>
            </div>


            <!-- Question 5: Cybersecurity level -->
            <h3>What is your level of technical knowledge on <u>cybersecurity</u>?</h3>
            <p style="margin-bottom: 10px;">The center is approximately the average of the population in the
                Netherlands.</p>
            <div class="form-item align-self">
                <label for="Very Low">
                    Very Low
                </label>
                <input type="radio" id="Very Low" value="Very Low" v-model="cybersecurity" />
                <input type="radio" id="Low" value="Low" v-model="cybersecurity" />
                <input type="radio" id="Average" value="Average" v-model="cybersecurity" />
                <input type="radio" id="High" value="High" v-model="cybersecurity" />
                <input type="radio" id="Expert" value="Expert" v-model="cybersecurity" />
                <label for="Expert">
                    Expert
                </label>
            </div>

            <!-- Question 6: Steganography level -->
            <h3>What is your level of technical knowledge on <u>steganography</u>?</h3>
            <p style="margin-bottom: 10px;">The center is approximately the average of the population in the
                Netherlands.</p>
            <div class="form-item align-self">
                <label for="Very Low">
                    Very Low
                </label>
                <input type="radio" id="Very Low" value="Very Low" v-model="steganography" />
                <input type="radio" id="Low" value="Low" v-model="steganography" />
                <input type="radio" id="Average" value="Average" v-model="steganography" />
                <input type="radio" id="High" value="High" v-model="steganography" />
                <input type="radio" id="Expert" value="Expert" v-model="steganography" />
                <label for="Expert">
                    Expert
                </label>
            </div>

            <!-- Question 7: Steganography explanation -->
            <h3>What is steganography?</h3>
            <div class="form-item">
                <input type="radio" id="1" value="1" v-model="stegoExplanation" />
                <label for="1">
                    I don't know.
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="2" value="2" v-model="stegoExplanation" />
                <label for="2">
                    A method of encrypting messages so that only authorized parties can read them.
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="3" value="3" v-model="stegoExplanation" />
                <label for="3">
                    The practice of hiding information within other non-secret data.
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="4" value="4" v-model="stegoExplanation" />
                <label for="4">
                    The study of deciphering geometric patterns in ancient texts.
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="5" value="5" v-model="stegoExplanation" />
                <label for="5">
                    The art of encrypting messages to make them unreadable without a key.
                </label>
            </div>
            <div class="form-item">
                <input type="radio" id="6" value="6" v-model="stegoExplanation" />
                <label for="6">
                    The technique of analyzing patterns in encrypted messages to uncover the content.
                </label>
            </div>

        </div>

        <!-- Game tips -->
        <div v-if="inGameGroup" style="margin-top: var(--standard-padding);">
            <h2>Game tips:</h2>
            <ul>
                <li>Do not reload the page</li>
                <li>Click anywhere on your screen to go to the next frame</li>
                <li>Use your mouse to answer questions and perform actions</li>
            </ul>
        </div>

        <!-- Error -->
        <p class="error" v-if="showError">
            * You have not yet filled in all the questions. Please check above whether you have missed something.
        </p>
        <p class="error" v-if="showServerError">
            * Something went wrong while saving your data. Are you sure your age is a whole number? Please try again. If
            this issue keeps arising, please <a href="mailto:f.g.j.weijsenfeld@student.utwente.nl">contact me</a>.
        </p>

        <div class="button">
            <Button v-if="inGameGroup" text="Start game" :onClick="next" />
            <Button v-else text="Start learning" :onClick="next" />
        </div>

    </TextTemplate>

</template>

<style scoped>
.form {
    margin-top: var(--standard-padding);
}

.example {
    font-size: 0.7rem;
}

.warning {
    margin-top: 10px;
    padding: var(--standard-padding);
    background-color: var(--error);
    border-radius: var(--rounded-big);
    color: var(--on-primary);
}
</style>
