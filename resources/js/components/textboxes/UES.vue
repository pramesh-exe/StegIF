<script setup>
import TextTemplate from '../TextTemplate.vue';
import Button from '../Button.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    inGameGroup: Boolean,
    experimentState: Number,
    participantId: String,
});

const showError = ref(false);
const showServerError = ref(false);
const emit = defineEmits(['update:experimentState']);

function next() {
    showServerError.value = false;
    showError.value = false;
    // Check if everything is filled in
    if (
        !FAS1.value
        || !FAS2.value
        || !FAS3.value
        || !PUS1.value
        || !PUS2.value
        || !PUS3.value
        || !AES1.value
        || !AES2.value
        || !AES3.value
        || !RWS1.value
        || !RWS2.value
        || !RWS3.value
    ) {
        showError.value = true;
        return;
    }
    // Send results to server
    const ues = {
        participant_id: props.participantId,
        fas1: FAS1.value,
        fas2: FAS2.value,
        fas3: FAS3.value,
        pus1: PUS1.value,
        pus2: PUS2.value,
        pus3: PUS3.value,
        aes1: AES1.value,
        aes2: AES2.value,
        aes3: AES3.value,
        rws1: RWS1.value,
        rws2: RWS2.value,
        rws3: RWS3.value,
    }
    axios.post('/api/ues/create', ues)
        .then((response) => {
            console.log("The participant's User Engagement Scale has been saved.");
            // Go to next part in the experiment
            emit('update:experimentState', 3);
        })
        .catch(error => {
            console.error('Error saving participant\'s User Engagement Scale:', error.response?.data.message);
            // Show error to user and ask to try again
            showServerError.value = true;
        });
}

function exitFullScreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();  // Firefox
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();  // Chrome, Safari
    } else if (document.msExitFullscreen) {
        document.msExitFullscreen();  // Internet Explorer
    }
}

onMounted(exitFullScreen);

const FAS1 = ref(null);
const FAS2 = ref(null);
const FAS3 = ref(null);
const PUS1 = ref(null);
const PUS2 = ref(null);
const PUS3 = ref(null);
const AES1 = ref(null);
const AES2 = ref(null);
const AES3 = ref(null);
const RWS1 = ref(null);
const RWS2 = ref(null);
const RWS3 = ref(null);

</script>

<template>
    <TextTemplate>

        <h2>User Engagement Form</h2>
        <div style="margin-bottom: var(--standard-padding);">
            <p>Please answer the questions below by considering the following scale:</p>
            <ol>
                <li>Strongly disagree</li>
                <li>Disagree</li>
                <li>Neither agree nor disagree</li>
                <li>Agree</li>
                <li>Strongly agree</li>
            </ol>
        </div>

        <div class="form">
            <!-- FAS1 -->
            <h3 v-if="inGameGroup">I lost myself in this gaming experience.</h3>
            <h3 v-else>I lost myself in this reading experience.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="FAS1" />
                <input type="radio" id="Disagree" :value="2" v-model="FAS1" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="FAS1" />
                <input type="radio" id="Agree" :value="4" v-model="FAS1" />
                <input type="radio" id="Strongly agree" :value="5" v-model="FAS1" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- FAS2 -->
            <h3 v-if="inGameGroup">The time I spent playing the game just slipped away.</h3>
            <h3 v-else>The time I spent reading the text just slipped away.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="FAS2" />
                <input type="radio" id="Disagree" :value="2" v-model="FAS2" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="FAS2" />
                <input type="radio" id="Agree" :value="4" v-model="FAS2" />
                <input type="radio" id="Strongly agree" :value="5" v-model="FAS2" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- FAS3 -->
            <h3 v-if="inGameGroup">I was absorbed in my gaming task.</h3>
            <h3 v-else>I was absorbed in my reading task.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="FAS3" />
                <input type="radio" id="Disagree" :value="2" v-model="FAS3" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="FAS3" />
                <input type="radio" id="Agree" :value="4" v-model="FAS3" />
                <input type="radio" id="Strongly agree" :value="5" v-model="FAS3" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- PUS1 -->
            <h3 v-if="inGameGroup">I felt frustrated while playing the game.</h3>
            <h3 v-else>I felt frustrated while reading the text.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="PUS1" />
                <input type="radio" id="Disagree" :value="2" v-model="PUS1" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="PUS1" />
                <input type="radio" id="Agree" :value="4" v-model="PUS1" />
                <input type="radio" id="Strongly agree" :value="5" v-model="PUS1" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- PUS2 -->
            <h3 v-if="inGameGroup">I found the game confusing to use.</h3>
            <h3 v-else>I found the text confusing.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="PUS2" />
                <input type="radio" id="Disagree" :value="2" v-model="PUS2" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="PUS2" />
                <input type="radio" id="Agree" :value="4" v-model="PUS2" />
                <input type="radio" id="Strongly agree" :value="5" v-model="PUS2" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- PUS3 -->
            <h3 v-if="inGameGroup">Using the game was mentally demanding.</h3>
            <h3 v-else>Reading the text was mentally demanding.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="PUS3" />
                <input type="radio" id="Disagree" :value="2" v-model="PUS3" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="PUS3" />
                <input type="radio" id="Agree" :value="4" v-model="PUS3" />
                <input type="radio" id="Strongly agree" :value="5" v-model="PUS3" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- AES1 -->
            <h3 v-if="inGameGroup">The game was attractive.</h3>
            <h3 v-else>The text was attractive.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="AES1" />
                <input type="radio" id="Disagree" :value="2" v-model="AES1" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="AES1" />
                <input type="radio" id="Agree" :value="4" v-model="AES1" />
                <input type="radio" id="Strongly agree" :value="5" v-model="AES1" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- AES2 -->
            <h3 v-if="inGameGroup">The game was aesthetically appealing.</h3>
            <h3 v-else>The text was aesthetically appealing.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="AES2" />
                <input type="radio" id="Disagree" :value="2" v-model="AES2" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="AES2" />
                <input type="radio" id="Agree" :value="4" v-model="AES2" />
                <input type="radio" id="Strongly agree" :value="5" v-model="AES2" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- AES3 -->
            <h3 v-if="inGameGroup">The game appealed to my visual senses.</h3>
            <h3 v-else>The text appealed to my visual senses.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="AES3" />
                <input type="radio" id="Disagree" :value="2" v-model="AES3" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="AES3" />
                <input type="radio" id="Agree" :value="4" v-model="AES3" />
                <input type="radio" id="Strongly agree" :value="5" v-model="AES3" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- RWS1 -->
            <h3 v-if="inGameGroup">Playing the game was worthwhile.</h3>
            <h3 v-else>Reading the text was worthwhile.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="RWS1" />
                <input type="radio" id="Disagree" :value="2" v-model="RWS1" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="RWS1" />
                <input type="radio" id="Agree" :value="4" v-model="RWS1" />
                <input type="radio" id="Strongly agree" :value="5" v-model="RWS1" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- RWS2 -->
            <h3 v-if="inGameGroup">My gaming experience was rewarding.</h3>
            <h3 v-else>My reading experience was rewarding.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="RWS2" />
                <input type="radio" id="Disagree" :value="2" v-model="RWS2" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="RWS2" />
                <input type="radio" id="Agree" :value="4" v-model="RWS2" />
                <input type="radio" id="Strongly agree" :value="5" v-model="RWS2" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>

            <!-- RWS3 -->
            <h3 v-if="inGameGroup">I felt interested in this gaming experience.</h3>
            <h3 v-else>I felt interested in this reading experience.</h3>
            <div class="form-item align-self">
                <label for="Strongly disagree">
                    Strongly disagree
                </label>
                <input type="radio" id="Strongly disagree" :value="1" v-model="RWS3" />
                <input type="radio" id="Disagree" :value="2" v-model="RWS3" />
                <input type="radio" id="Neither agree nor disagree" :value="3" v-model="RWS3" />
                <input type="radio" id="Agree" :value="4" v-model="RWS3" />
                <input type="radio" id="Strongly agree" :value="5" v-model="RWS3" />
                <label for="Strongly agree">
                    Strongly agree
                </label>
            </div>
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
