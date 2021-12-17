<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public') }}/assets/css/app.css">
    <title>Login/Register Form</title>
</head>

<body>
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissable mx-2 my-2" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('error') }}
            </div>
        @endif

        @isset($error)
            @if ($error != null)
                <div class="alert alert-danger alert-dismissable mx-2 my-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $error ?? '' }}
                </div>
            @else

            @endif
        @endisset
        {{-- <button id="showToast" class="btn btn-primary btn-lg w-25 mx-auto">Show Toast</button>
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000"
            style="position: absolute; top: 1rem; right: 1rem;">
            <div class="toast-header">

                <strong class="mr-auto">Bootstrap</strong>
                <small>11 mins ago</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div> --}}
        <div id="logreg-forms">
            <!-- Use a button to open the snackbar -->
            {{-- @isset($error)
                @if ($error != '')
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ $error }}
                    </div>
                @endif
            @endisset --}}


            {{-- <div class="toast show invisible" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                </div>
            </div> --}}

            <form class="form-signin" method="POST" action="{{ url('login') }}">
                @csrf
                <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
                <div class="social-login">
                    <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i>
                            Sign
                            in
                            with Facebook</span> </button>
                    <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i>
                            Sign in with Google+</span> </button>
                </div>
                <p style="text-align:center"> OR </p>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address"
                    required="" autofocus="">
                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password"
                    required="">

                <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign
                    in</button>
                <a href="#" id="forgot_pswd">Forgot password?</a>
                <hr>
                <!-- <p>Don't have an account!</p>  -->
                <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i>
                    Sign up New Account</button>
            </form>

            <form action="/reset/password/" class="form-reset">
                <input type="email" id="resetEmail" class="form-control" placeholder="Email address" required=""
                    autofocus="">
                <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
            </form>

            <form method="POST" action="{{ url('register') }}" class="form-signup">
                @csrf
                <div class="social-login">
                    <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i>
                            Sign up with Facebook</span> </button>
                </div>
                <div class="social-login">
                    <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i>
                            Sign up with Google+</span> </button>
                </div>

                <p style="text-align:center">OR</p>

                <input type="text" id="user-name" name="first_name" class="form-control" placeholder="First name"
                    required="" autofocus="">
                <input type="text" id="user-name" name="last_name" class="form-control" placeholder="Last name"
                    required="" autofocus="">
                <input type="email" id="user-email" name="email" class="form-control" placeholder="Email address"
                    required autofocus="">
                <input type="password" id="user-pass" name="password" class="form-control" placeholder="Password"
                    required autofocus="">
                <input type="password" id="user-repeatpass" name="repeatpass" class="form-control"
                    placeholder="Repeat Password" required autofocus="">

                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign
                    Up</button>

                <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
            </form>
            <br>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="/script.js"></script>
    <script type="text/javascript">
        // A $( document ).ready() block.
        $(document).ready(function() {

            $("#showToast").click(function() {
                $('.toast').toast('show');
            });

        });

        function toggleResetPswd(e) {
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle() // display:block or none
            $('#logreg-forms .form-reset').toggle() // display:block or none
        }

        function toggleSignUp(e) {
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle(); // display:block or none
            $('#logreg-forms .form-signup').toggle(); // display:block or none
        }

        $(() => {
            // Login Register Form
            $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
            $('#logreg-forms #cancel_reset').click(toggleResetPswd);
            $('#logreg-forms #btn-signup').click(toggleSignUp);
            $('#logreg-forms #cancel_signup').click(toggleSignUp);
        })
    </script>
</body>

</html>
