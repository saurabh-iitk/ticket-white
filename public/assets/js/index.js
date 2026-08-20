document.addEventListener('DOMContentLoaded', (event) => {
    const checkboxes = document.querySelectorAll('.ticket-checkbox');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('click', () => {
            checkboxes.forEach((box) => {
                if (box !== checkbox) {
                    box.checked = false;
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const checkboxes = document.querySelectorAll('.ticket-checkbox-2');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('click', () => {
            checkboxes.forEach((box) => {
                if (box !== checkbox) {
                    box.checked = false;
                }
            });
        });
    });
});
// Wait for the entire page to load
window.addEventListener('load', function () {
    // Hide the preloader
    var preloader = document.getElementById('preloader');
    preloader.style.display = 'none';
    
    // Show the content
    var content = document.getElementById('content');
    content.style.display = 'block';
});
