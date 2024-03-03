function previewProfilePicture() {
    var preview = document.getElementById('profilePicturePreview');
    var fileInput = document.getElementById('profilePicture').files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (fileInput) {
        reader.readAsDataURL(fileInput);
    } else {
        preview.src = '\SJNHSAlumniSystem/admin/assets/img/user.png'; // Set default image
    }
}

function previewEventPicture() {
    var preview = document.getElementById('eventPicturePreview');
    var fileInput = document.getElementById('eventPicture').files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (fileInput) {
        reader.readAsDataURL(fileInput);
    } else {
        preview.src = 'assets/img/undraw_festivities_tvvj.png'; // Set default image
    }
}

function previewNewsPicture() {
    var preview = document.getElementById('newsPicturePreview');
    var fileInput = document.getElementById('newsPicture').files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (fileInput) {
        reader.readAsDataURL(fileInput);
    } else {
        preview.src = 'assets/img/undraw_Newspaper_re_syf5.png'; // Set default image
    }
}

function previewEditNewsPicture() {
    const preview = document.getElementById('newsPicturePreview');
    const file = document.getElementById('editPicture').files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}


