function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
}

// Auto-resize on load for existing content
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea');
    if (textarea) {
        autoResize(textarea);
    }
});

const rightSectionBtn = document.getElementById('rightSectionBtn');
const rightSection = document.getElementById('rightSection');

rightSectionBtn.addEventListener('click', function() {
    if (rightSection.classList.contains('w-0')) {
        rightSection.classList.remove('w-0');
        rightSection.classList.add('w-80');
    } else {
        rightSection.classList.remove('w-80');
        rightSection.classList.add('w-0');
    }
});

// File input
const attachButton = document.getElementById('attachButton');
const fileInput = document.getElementById('fileInput');

attachButton.addEventListener('click', function() {
    fileInput.click();
});

fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        console.log('File selected:', file.name, file.type, file.size);
        // Do something with the file
        // For example: uploadFile(file);
    }
});

// Photo input
const photoButton = document.getElementById('photoButton');
const photoInput = document.getElementById('photoInput');

photoButton.addEventListener('click', function() {
    photoInput.click();
});

photoInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        console.log('Photo selected:', {
            name: file.name,
            type: file.type,
            size: (file.size / 1024).toFixed(2) + ' KB',
            dimensions: 'Will be available after loading'
        });
        // Process the photo
        previewPhoto(file);
    }
});
