<script setup>
import { onMounted } from 'vue';
import TextTemplate from '../TextTemplate.vue';
import { removeLeavePageWarning } from '../leavePageWarning';

onMounted(removeLeavePageWarning);

</script>

<template>
    <TextTemplate>
        <h2>Thank you for participating!</h2>
        <p>
            Please ask other people to participate in this study as well. That would be
            really helpful! They can simply visit <a href="https://game.femkew.nl">game.femkew.nl</a> to participate.
        </p>
        <!--
        <p>
            If you are interested in the topic, you can find some extra material
            <a href="https://stegadventure.femkew.nl/extra-info" target="_blank">here</a>.
        </p>
        -->
        <p>
            If you were in the reading group, but still interested in playing the game, you can do that
            <a href="https://stegadventure.femkew.nl/game" target="_blank">here</a>.
        </p>
    </TextTemplate>
</template>
