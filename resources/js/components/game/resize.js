import { nextTick } from 'vue';

export function updateContainerSize(backgroundImage, backgroundContainer, fontSizeText, fontSizeChoice) {
    nextTick(() => {
        if (!backgroundImage.value || !backgroundContainer.value) return;

        // Calculate visible dimensions
        const { naturalWidth, naturalHeight } = backgroundImage.value;
        const aspectRatio = naturalWidth / naturalHeight;
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        let width, height;
        if (viewportWidth / viewportHeight > aspectRatio) {
            // Screen is wider than the image
            height = viewportHeight;
            width = viewportHeight * aspectRatio;
        } else {
            // Screen is taller than the image
            width = viewportWidth;
            height = viewportWidth / aspectRatio;
        }

        // Apply visible dimensions to the container
        backgroundContainer.value.style.width = `${width}px`;
        backgroundContainer.value.style.height = `${height}px`;

        // Update font sizes based on image height
        fontSizeText.value = `${height * 0.035}px`; // 3.5% of image height
        fontSizeChoice.value = `${height * 0.030}px`; // 3% of image height
    });
}
