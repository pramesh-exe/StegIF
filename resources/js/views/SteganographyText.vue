<script setup>
import TextTemplate from '../components/TextTemplate.vue';
import Button from '../components/Button.vue';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';
// Images
import encryptionScheme from '../../img/text/Asymmetric_encryption_scheme.png';
import caesarCipher from '../../img/text/Caesar_Shift_Cipher_Wheel.png';
import uvInk from '../../img/text/Written_text_with_UV_ink.jpg';

const props = defineProps({
    experimentState: Number,
    participantId: String,
});

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

const emit = defineEmits(['update:experimentState']);
function next() {
    // Send time in seconds since start of reading
    const read = {
        participant_id: props.participantId,
        time_since_start: timeSinceStart.value,
    }
    axios.post('/api/reading/add', read)
        .then((response) => {
            console.log("The reading time has been saved.");
            emit('update:experimentState', 2);
        })
        .catch(error => {
            console.error('Error saving the reading time:', error.response?.data.message);
        });
}
</script>

<template>
    <TextTemplate>

        <h2>Cyber security</h2>
        <p>
            Cyber security is the practise of protecting systems, networks and data from digital threats. The world
            keeps becoming more and more connected and thus the risk of cyber attacks inceases too. Companies have had
            data leakages, and even personal computers have been locked by ransomware by criminals. Therefore, digital
            systems must be protected.
        </p>
        <p>
            This reading will focus on safe and secret communication. We will start with a very known concept:
            cryptography. Then we will focus in the main topic: steganography.
        </p>

        <h3>Cryptography</h3>
        <p>
            In cryptography, a plaintext will be encrypted. The plaintext is the readable message that needs to be send.
            When the plaintext is encrypted with an encryption key, it should be unreadable for a possible interceptor
            of
            the message. The receiver can then decrypt the message with the decryption key.
        </p>

        <div id="figure-1" class="image-wrapper">
            <img :src="caesarCipher" />
            <p><b>Figure 1:</b> Caesar Cipher Wheel for shifting letters</p>
        </div>
        <p>
            A famous basic cryptography algorithm is the Caesar Cipher, in which each alphabet letter is shifted by a
            certain amount. For example, you can replace all 'A' by 'B'. 'BAG' will then become 'CBH'. The encryption
            key is the number of
            shifted letters, which was 1 in the previous sentence. The decryption key is -1, since all letters should be
            shifted one back in the alphabet. The Caesar Chipher Wheel for key 19 is shown in
            <a href="#figure-1">Figure 1</a>.
        </p>

        <p>
            The most used form of encryption in the modern internet is assymetric encryption, which means that the key
            for encryption is different than the key for decryption. The idea is that Alice wants to receive a message,
            and thus generates a mathematically connected public and private key. She will share the public key with
            everyone, and makes sure nobody knows the private key. People who want to send her a message will encrypt
            their message with the public key. After encryption, even the sender cannot decrypt the message anymore.
            When Alice receives the message, she can decrypt it with her private key. As long as the private key is not
            known or cannot be guessed, the message's content is safe. This process is illustrated in
            <a href="#figure-2">Figure 2</a>.
        </p>
        <div id="figure-2" class="image-wrapper">
            <img :src="encryptionScheme" />
            <p><b>Figure 2:</b> Encryption scheme for assymetric encryption</p>
        </div>

        <h3>Steganography</h3>
        <p>
            Steganography is a very different principal of secret communication. Instead of making the send text
            unreadable, you hide the existence of the secret message. An example of this is writing a letter which seems
            no harm, but instead you have written the real message within the lines with invisible ink
            (<a href="#figure-3">Figure 3</a>).
        </p>
        <div id="figure-3" class="image-wrapper">
            <img :src="uvInk" />
            <p><b>Figure 3:</b> Something secret can be written with UV ink on an unharmful looking document</p>
        </div>
        <p>
            One of the first records of steganography is from 499BC. The ruler of Miletus, Histieaus, shaved the head of
            one of his
            most trusted slaves and tattooed a message. Then he waited untill the hair was grown back and send him to
            Aristagoras, who shaved the head and read the intruction to revolt against the Persians. The hidden message
            was tattooed and the cover was the slave.
        </p>
        <p>
            In the digital world, messages can be hidden within digital files as cover, like audio fragments, PDF files,
            images, and many more digital media. These files are represented by bits, and by adjusting or adding bits,
            secret messages can be embedded into these files.
        </p>

        <h2>Steganography vs cryptography</h2>
        <p>
            The important difference is that steganography hides existence of the message, while in cryptography, it is
            known that something is communicated. Steganography can therefore also be called the art of hiding, while
            cryptography is the art of secret writing.
        </p>
        <p>
            Cryptography is therefore used to make the message's content secret, while steganography is used to hide the
            existence of a secret message. They are not mutually exclusive, because you can hide an encrypted message
            as well.
        </p>

        <h2>Relevance</h2>
        <p>
            Steganography can be used as a communication method. For example, it is said that Al-Qaeda used it in
            preparation for the 9/11 suicide attacks. Unharmful looking images were posted online. Those contained
            secret messages with communications for the attack.
        </p>
        <p>
            Research also shows that alarming number of images nowadays seem to contain steganography on eBay. This is
            concluded by using StegAnalysis tools to check with either statistics or AI whether a hidden message may be
            embedded inside the image. Still, since steganography is the art of hiding, it is unclear what message was
            contained and if steganography was really used. But people can just post images anonymously and others can
            download them anonymously to retrieve the message.
        </p>
        <p>
            Steganography can also be used for creating malicious software (malware). More about this in a later
            section. Let's first see how steganography is applied in for example an image.
        </p>

        <h2>Image steganography</h2>
        <h3>Hiding inside an image</h3>
        <p>
            To hide a message in an image, one must first understand how pixels on the computer are represented. Each
            pixel on the computer is a mix of three colours of light: Red, Green and Blue (RGB). In many cases, each
            colour can have a value between 0 and 255, meaning how strong the value is. For example if red is 0, then no
            red is in the total colour, and if red is 255, red is represented very well in the colour. A certain colour
            may therefore look as follows: <span class="color-1">RGB(255, 101, 194)</span>. Over 16 million colours can
            be represented this way.
        </p>
        <p>
            So, a colour is represented by numbers. A computer does not read decimal numbers directly though, but will
            transform it to bits. The above mentioned colour can therefore be converted to bits:
            <span class="color-1"><b>11111111 01100101 11000010</b></span>
            (in decimal: 255, 101, 194).
        </p>
        <p>
            When we flip the least significant bit of each colour value, we get <span class="color-2">1111111<b>0</b>
                0110010<b>0</b> 1100001<b>1</b></span>. Note how the most-right bit of each group of 8 bits (a byte) is
            changed. The change in colour is present, but barely visible with the human eye in an image with lots of
            noise.
        </p>
        <p>
            Since changing this last bit does not influence the pixel colour, and thus the image very much we can use
            those bits to hide a message! Let's say our protocol is that each letter of the alphabet is the number in
            the alphabet (e.g. 'a' is 1, and 'y' is 25). Then we can represent 'y' as 011001 in binary. We can then
            change each of the least significant bits of the image to put the letter 'y' hidden inside the image, like
            so:<br />
            <span class="color-3">1100111<b>0</b> 1111110<b>1</b> 0001010<b>1</b></span>
            <br />
            <span class="color-4">1101000<b>0</b> 1010101<b>0</b> 0000101<b>1</b></span>
            <br />
            These are just random example pixel colours. Notice how the fat numbers make up the letter 'y' in binary:
            011001. Adjusting bits will create slight colour changes, but these slight color changes are barely visible
            with the human eye and have minimal impact in images with lots of colour changes.
        </p>
        <p>
            This is a way of embedding a message within an image. There are also other ways that do not use the least
            significant bits, like techniques involving the adding of bits at none-visible places and techniques that
            use formulas to hide the message.
        </p>

        <h3>Stego key</h3>
        <p>
            If all least significant bits are used for the message, someone may then easily extract the message if they
            suspect its existence. Therefore, a stego key can be introduced. A stego key will randomize which bits are
            used for the message. Then only people who have access to this stego key can extract the secret message.
            Randomization of which bits are used for steganography may also make it harder for StegAnalysis tools to see
            whether the image contains steganography or not. So, the best stego file has a hidden message, a good cover
            file and a strong stego key.
        </p>

        <h2>StegWare</h2>
        <p>
            Malware that makes use of steganography is called StegWare. The main idea of StegWare is to avoid
            anti-malware systems by hiding the attack in another digital object (e.g. PDF, image, Excel sheet, etc.).
            This way, anti-malware systems may not see the existence of such attack. While encryption hides the exact
            attack, it does not hide its possible existence and will therefore usually be blocked by Intrusion Detection
            Systems. Steganography hides the existence of the attack, making it hard to detect.
        </p>
        <p>
            For example, an PDF with malware embedded within may be shared through email. If the receiver downloads
            and opens the PDF, there is a possibility that the hidden malware will be extracted from the PDF and be
            executed. Ransomware may block a computer this way. Therefore, it is advised to not download files of
            unknown origin.
        </p>
        <p>
            This is not the only possibility. Hackers have been able to put Javascript code within images on compromised
            webshops. When people fill in their credit card details, they are also send to the hackers. The webshop may
            even not be aware of this happening. They should be up to date with the latest cyber security defense to
            prevent this from happening.
        </p>

        <h2>Summary</h2>
        <p>
            All in all, steganography is a method for hiding messages. For example, these messages can hide secret
            communication, or they can hide an cyber attack. In an increasingly digital world, people should be aware of
            the existence of steganography.
        </p>

        <div class="button">
            <Button text="I have read the text" :onClick="next" />
        </div>
    </TextTemplate>
</template>

<style scoped>
img {
    max-width: 100%;
    height: 300px;
    object-fit: contain;
}

.image-wrapper {
    display: flex;
    text-align: center;
    flex-direction: column;
    justify-content: center;
    margin-bottom: 15px;
    margin-top: 15px;
    gap: 5px;
    font-style: italic
}

.color-1,
.color-2,
.color-3,
.color-4 {
    border-radius: 4px;
    padding: 1px;
}

.color-3,
.color-4 {
    padding: 2px;
    line-height: 2;
}

.color-1 {
    background-color: RGB(255, 101, 194);

}

.color-2 {
    background-color: RGB(254, 100, 193);
}

.color-3 {
    background-color: #cefd15;
}

.color-4 {
    background-color: #d0aa0b;
}
</style>
