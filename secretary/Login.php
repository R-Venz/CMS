<?php require_once("../include/Initialize.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hero</title>


    <meta name="robots" content="noindex">

    <link type="text/css" href="assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="assets/css/app.rtl.css" rel="stylesheet">

    <link type="text/css" href="assets/vendor/simplebar.css" rel="stylesheet">
</head> -->
<?php include_once 'theme/header.php';  ?>
<body>
    <div class="mdk-drawer-layout js-mdk-drawer-layout" data-fullbleed data-push data-has-scrolling-region>
        <div class="mdk-drawer-layout__content mdk-header-layout__content--scrollable" style="overflow-y: auto;" data-simplebar data-simplebar-force-enabled="true">


            <div class="container h-vh d-flex justify-content-center align-items-center flex-column">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <a href="index.html" class="drawer-brand-circle mr-2">CF</a>
                    <h2 class="ml-2 text-bg mb-0"><strong>Community Funeral Fund</strong></h2>
                </div>
                <div class="row w-100 justify-content-center">
                    <div class="card card-login mb-3">
                        <div class="card-body">
                            <form id="submit_log" method="post">
                                <div class="form-group">
                                    <label>Username</label>

                                    <div class="input-group input-group--inline">
                                        <div class="input-group-addon">
                                            <i class="material-icons">account_circle</i>
                                        </div>
                                        <input type="text" class="form-control" name="u" value="" placeholder="Enter your username" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex">
                                        <label>Password</label>
                                        <!-- <span class="ml-auto"><a href="forgot-password.html">Forgot password?</a></span> -->
                                    </div>

                                    <div class="input-group input-group--inline">
                                        <div class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </div>
                                        <input type="password" class="form-control" name="p" value="" placeholder="Enter your password" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- <div class="d-flex justify-content-center">
                    <span class="mr-2">Don't have an account?</span>
                    <a href="signup.html">Sign Up</a>
                </div> -->
            </div>


        </div>
    </div>

    <?php include_once 'theme/scripts.php';  ?>
    <script>
        $('#submit_log').on('submit', function(e){
            e.preventDefault();
            $.ajax({  
                url:"<?php echo web_root; ?>php/login/secretary-log.php",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                //cache:false,  
                processData:false,  
                success:function(data){
                    if (data==1) {
                        window.location.href = "../secretary/?p=1";
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
</body>

</html>