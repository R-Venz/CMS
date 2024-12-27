<?php require_once("../include/Initialize.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../assets/images/logo.png">
    <title>CMS</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            transition: background-color 0.5s, color 0.5s;
            background: radial-gradient(circle, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.5) 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .theme-halloween {
            background-color: #1c1c1c;
            color: #535353;
            background-image: url('5ff873fb-5b3f-4467-ad6b-b98fa6a00887.webp');
        }

        .theme-christmas {
            background-color: #004d00;
            color: orangered!important;
            background-image: url('59bb4091-d935-4e3c-8853-44198e6eb85d.webp');
        }

        .theme-valentines {
            background-color: #ffccd5;
            color: #ff1744;
        }

        .theme-holy-week {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .carousel-inner img {
            height: 400px;
            object-fit: cover;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.85); /* White with 85% opacity */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Add thematic buttons */
        .btn-halloween {
            background-color: orange;
            border: none;
        }

        .btn-christmas {
            background-color: #008000;
            border: none;
        }

        .btn-valentines {
            background-color: #ff1744;
            border: none;
        }

        .btn-holy-week {
            background-color: #6c757d;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">La-Victoria Kapunongan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul> -->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <!-- Carousel Section -->
            <div class="col-md-8">
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?=web_root?>assets/images/1.webp" class="d-block w-100" alt="Slide 1">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?=web_root?>assets/images/2.jpg" class="d-block w-100" alt="Slide 2">
                            <div class="carousel-caption d-none d-md-block" style="-webkit-text-stroke-width: 1px;
                                -webkit-text-stroke-color: black;">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?=web_root?>assets/images/3.png" class="d-block w-100" alt="Slide 3">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            <!-- Login Form Section -->
            <div class="col-md-4">
                <div class="login-form">
                    <h3 class="text-center">Sign Up</h3>
                    <form id="submit_log">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input required type="text" class="form-control" id="fname" name="fname" placeholder="Enter your first name">
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input required type="text" class="form-control" id="lname" name="lname" placeholder="Enter your last name">
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input required type="date" class="form-control" id="dob" name="dob" placeholder="Enter your birthday">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input required type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="pass1" class="form-label">Password</label>
                            <input required type="password" class="form-control" id="pass1" name="pass1" placeholder="Enter your password">
                        </div>
                        <div class="mb-3">
                            <label for="pass2" class="form-label">Re-Enter Password</label>
                            <input required type="password" class="form-control" id="pass2" name="pass2" placeholder="Enter your password again">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                        <p class="text-center mt-3">Already have an account? <a href="Login.php">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript for Dynamic Theme -->
    <script>
        const body = document.body;

        function applySeasonalTheme() {
            body.className = 'theme-christmas';
        }

        // Apply the theme on page load
        document.addEventListener("DOMContentLoaded", applySeasonalTheme);
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php include_once 'theme/scripts.php';  ?>
    <script>
        $('#submit_log').on('submit', function(e){
            e.preventDefault();
            $.ajax({  
                url:"<?php echo web_root; ?>php/login/member-register.php",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                //cache:false,  
                processData:false,  
                success:function(data){
                    if (data==1) {
                        alert("You successfully created an account.")
                        window.location.href = "Login.php";
                    }else{
                        Swal.fire({
                            title: 'Warning',
                            text: data.replace(/^[ ]+/g),
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        })
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: textStatus + " " + errorThrown,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }  
            })  
        });
    </script>
