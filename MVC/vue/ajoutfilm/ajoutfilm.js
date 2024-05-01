$().ready(init);

$().ready(init);

function init() {
    const currentUrl = window.location.href;
    if (currentUrl === 'http://localhost/Event-It/MVC/?path=pages/voirfilm') {
        const link = document.getElementById('links-film');
        link.href = './?path=pages/voirfilm';
        link.innerHTML = 'Informations Film';
        const submitButton = document.querySelector('.button-ajout-film');
        if (submitButton) {
            submitButton.style.display = 'none';
        }

        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.disabled = true;
        });

        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.disabled = true;
        });
    }
}

function ajoutimg(e) {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onloadend = function () {
        document.querySelector('.image-container img').src = reader.result;
        document.getElementById('imageChoisi').style.display = 'none'; // cache l'input
        document.querySelector('.image-container').style.display = 'flex'; // affiche l'image
        document.getElementById('delete-img').style.display = 'block'; // affiche le bouton de suppression
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        document.querySelector('.image-container img').src = "";
        document.getElementById('imageChoisi').style.display = 'block'; // affiche l'input
        document.querySelector('.image-container img').style.display = 'none'; // cache l'image
    }
};

function deleteimg() {
    document.querySelector('.image-container img').src = "";
    document.getElementById('imageChoisi').value = ""; // reset l'input
    document.getElementById('imageChoisi').style.display = 'block'; // affiche l'input
    document.querySelector('.image-container').style.display = 'none'; // cache l'image
    document.getElementById('delete-img').style.display = 'none'; // cache le bouton de suppression
}