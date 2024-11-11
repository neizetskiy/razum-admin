if (document.getElementById('reg')) {
    $("#reg").on("submit", function (e) {
        $.ajax({
            url: '../../actions/signup.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                if (data != 'yes') {
                    document.getElementById('errorLabel').textContent = data;
                    let inputs = document.querySelectorAll('.input-form')
                    for (let i = 0; i < inputs.length; i++) {
                        if (inputs[i].value.trim() === '') {
                            inputs[i].classList.add('error-input')
                        }
                        else {
                            inputs[i].classList.remove('error-input')
                        }
                    }
                }
                else {
                    window.location = "/?page=etap";
                }
            }
        });
        e.preventDefault();
    });
}

if (document.getElementById('auth')) {
    $("#phone").inputmask("+79999999999");
    $("#auth").on("submit", function (e) {

        let phoneInput = document.querySelector('input[name="phone"]');
        let phonePattern = /^\+7\d{10}$/;

        $.ajax({
            url: '../../actions/signin.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                if (data != 'yes') {
                    document.getElementById('errorLabelauth').textContent = data;
                    let inputs = document.querySelectorAll('.input-form')
                    for (let i = 0; i < inputs.length; i++) {
                        if (inputs[i].value.trim() === '') {
                            inputs[i].classList.add('error-input')
                        }
                        else {
                            inputs[i].classList.remove('error-input')
                        }
                    }

                    if (!phonePattern.test(phoneInput.value.trim())) {
                        phoneInput.classList.add('error-input');
                    }
                }
                else {
                    window.location = "/?page=adminUsers";
                }
            }
        });
        e.preventDefault();
    });
}

if (document.getElementById('promo')) {
    $("#promo").on("submit", function (e) {
        $.ajax({
            url: '../../actions/addPromo.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                if (data != 'yes') {
                    document.getElementById('errorSettings').textContent = data;
                }
                else {
                    window.location = "../../?page=settings";
                }
            }
        });
        e.preventDefault();
    });
}

if (document.getElementById('courses')) {
    $("#courses").on("submit", function (e) {
        $.ajax({
            url: '../../actions/addCourses.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                if (data != 'yes') {
                    document.getElementById('erroraddCourses').textContent = data;
                }
                else {
                    window.location = "../../?page=adminCourses";
                }
            }
        });
        e.preventDefault();
    });
}


if (document.getElementById('lessons')) {
    $("#lessons").on("submit", function (e) {
        $.ajax({
            url: '../../actions/addLesson.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                if (data != 'yes') {
                    document.getElementById('erroraddLessons').textContent = data;
                }
                else {
                    window.location = "../../?page=adminCourses";
                }
            }
        });
        e.preventDefault();
    });
}


if (document.getElementById('modalRole')) {
    $("#modalRole").on("submit", function (e) {
        $.ajax({
            url: '../../actions/updaterole.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                window.location = `../../?page=adminuserprofile&${data}`;
            }
        });
        e.preventDefault();
    });
}