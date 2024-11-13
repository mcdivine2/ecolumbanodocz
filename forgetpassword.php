<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="asset/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/libs/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
            min-height: 105%;
            background: linear-gradient(0deg, rgba(2, 115, 0), rgba(35, 152, 228, 0.4)), url("asset/images/scc-bg2.png");
            background-size: cover;
        }

        body {
            justify-content: flex-start;
            align-items: flex-start;
            padding-bottom: 40px;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #d6a92b;
        }

        .button1:hover {
            background-color: #d6a92b;
            color: white;
        }

        .loading-icon {
            display: none;
            margin-left: 10px;
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary" style="background: rgb(17,10,134);
            background: linear-gradient(90deg, rgba(1,68,33) 0%, rgba(18,53,36) 28%, rgba(0,102,0) 100%);">
    </nav>

    <div class="splash-container" style="margin-top: 50px">
        <div class="card">
            <div class="card-header text-center">
                <a href="index.php"><img class="scc_logo" src="asset/images/scc_logo.png" alt="SCC_logo" height="200px"></a>
            </div>
            <div class="card-body">
                <form method="post" name="forgot_password_form">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input class="form-control form-control-lg" id="email" type="email" placeholder="Enter your email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-block button1" type="submit" id="btn-reset">Send Reset Link</button>
                        <img src="asset/images/loading.gif" class="loading-icon" alt="Loading">
                    </div>
                    <div class="form-group" id="alert-msg"></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="../asset/vendor/parsley/parsley.js"></script>
    <script src="../asset/libs/js/main-js.js"></script>
    <script type="text/javascript">
        document.oncontextmenu = document.body.oncontextmenu = function() {
            return false;
        } //disable right click
    </script>

    <script>
        $(document).ready(function() {
            const button = $('#btn-reset');
            const loadingIcon = $('.loading-icon');
            const alertMsg = $('#alert-msg');

            // Handle form submission
            $('form[name="forgot_password_form"]').on('submit', function(e) {
                e.preventDefault();

                const email = $('#email').val();
                if (!email) {
                    alertMsg.html('<div class="alert alert-danger">Please enter your email!</div>');
                    return;
                }

                // Show loading icon and disable button
                loadingIcon.show();
                button.prop('disabled', true);

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'init/controllers/forgot_password_process.php',
                    data: {
                        email: email
                    },
                    success: function(response) {
                        // Parse response and set the message
                        let jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            alertMsg.html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                        } else {
                            alertMsg.html('<div class="alert alert-danger">' + jsonResponse.message + '</div>');
                        }
                    },
                    error: function() {
                        alertMsg.html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                    }
                });

                // Hide the loading icon and show prompt after 5 seconds
                setTimeout(function() {
                    loadingIcon.hide(); // Hide loading icon
                    button.prop('disabled', false); // Re-enable button if necessary
                    alertMsg.append('<div class="alert alert-info">If successful, please check your email.</div>');
                }, 5000); // 5 seconds
            });
        });
    </script>
</body>

</html>