<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="./themes/template2/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        #branding {
            background-image: url(./themes/template2/images/login-img.png);
            background-repeat: no-repeat;
            background-size: 900px 850px;
            background-position: left bottom;
        }
    </style>

</head>

<body>

    <div class="body">
        <div role="main" class="main">

            <div class="header-logo mt-0 mb-0">
                <a href="####">

                </a>
            </div>
            <div class="container">

            </div>

            <div class="row vh-100">
                <div id="branding" class="col-md-7 d-none d-md-block"></div>
                <div class="col col-md-5 mt-5 float-end">
                    <div class="login-section">
                        <a class="text-decoration-none container " href="####"><i class="fas fa-chevron-left text-1 me-1"></i>back</a>
                        <h3 class="mt-5 pt-5 container">Login</h3>
                        <form action="/" id="frmSignIn" method="post" class="needs-validation container " novalidate>
                            <div class="row align-items-center g-3 ">
                                <div class="form-group col-auto">
                                    <img src="./themes/template2/images/username-icon.png">
                                </div>
                                <div class="form-group col">
                                    <input type="text" value="" class="form-control form-control-lg" placeholder="Username" required>
                                    <div class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                </div>
                            </div><br>
                            <div class="row align-items-center g-3">
                                <div class="form-group col-auto">
                                    <img src="./themes/template2/images/password-icon.png">
                                </div>
                                <div class="form-group col">
                                    <input type="password" value="" class="form-control form-control-lg" placeholder="Password" required>
                                    <div class="invalid-feedback">
                                        Please choose a password.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col ">
                                    <a class="text-decoration-none text-color-dark text-color-hover-primary text-3 float-end" href="#####">Forgotten Password?</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <button type="submit" class="btn btn-danger w-100 text-4 py-2 my-4" data-loading-text="Loading..." style='background-color:#E0001A;'>เข้าสู่ระบบ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

</body>

</html>