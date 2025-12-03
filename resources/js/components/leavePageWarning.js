// Define the event handler separately
function beforeUnloadHandler(e) {
    var confirmationMessage = 'Are you sure you want to quit the experiment? All your changes will be lost.';

    (e || window.event).returnValue = confirmationMessage; // Gecko + IE
    return confirmationMessage; // Gecko + Webkit, Safari, Chrome, etc.
}

// Function to add the event listener
export function leavePageWarning() {
    window.addEventListener("beforeunload", beforeUnloadHandler);
}

// Function to remove the event listener
export function removeLeavePageWarning() {
    window.removeEventListener("beforeunload", beforeUnloadHandler);
}

