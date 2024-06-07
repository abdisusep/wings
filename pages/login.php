<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-lg-5 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <form id="loginForm">
                            <div class="mb-3 text-center">
                                <h4>Login</h4>
                            </div>
                            <div class="mb-3">
                                <label for="user" class="form-label">User</label>
                                <input type="text" class="form-control" id="user" placeholder="User" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){
            $('#loginForm').on('submit', function(e){
                e.preventDefault();

                var user = $('#user').val();
                var password = $('#password').val();

                $.ajax({
                    url: 'json/login.php',
                    type: 'POST',
                    data: {user: user, password: password},
                    success: function(response){
                        if (response.status === 'success') {
                            console.log(response);
                            window.location.href = '?p=home';
                        }else{
                            console.log(response);
                            Swal.fire({
                                icon: "warning",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }
                });
            });
        });

    </script>
</body>
</html>
