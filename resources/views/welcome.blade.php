<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kiosque - Se connecter</title>
    <link rel="stylesheet" href="{{ asset('assets/fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <link rel="stylesheet" href="{{ asset('/assets/login.css') }}" />

</head>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" /> --}}

<body class="container">
    <div class="bg-flou"></div>
    <div class="row d-flex flex-column vh-100 justify-content-center align-items-center w-100 form-container mx-auto">
        <div class="col-md-6">
            <div class="p">

                <form class="user bg-gradient-light p-4 rounded-0 shadow" id="user_auth_form">
                    <div class="text-center">
                        <h4 class="text-dark  fw-bolder mb-4">Connectez-vous</h4>
                    </div>
                    <div class="mb-3"><input id="exampleInputEmail"
                            class="form-control shadow-none form-control-user rounded-2 " type="text"
                            aria-describedby="" required placeholder="Votre login" name="login" />
                    </div>
                    <div class="mb-3">
                        <input id="" class="form-control form-control-user shadow-none  rounded-2"
                            type="password" placeholder="Mot de passe" name="password" required />
                    </div>
                    <div class="mb-3">
                        {{-- <div class="custom-control custom-checkbox small">
                            <div class="form-check"><input id="formCheck-1"
                                    class="form-check-input custom-control-input" type="checkbox" /><label
                                    class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label>
                            </div>
                        </div> --}}
                    </div><button class="btn bg-gradient-dark d-block btn-user mt-3 w-100 text-light rounded-2"
                        type="submit">Connexion <i class="fal fa-sign-in-alt"></i>
                        <div id="spinner" class="spinner-border mx-2 spinner-border-sm text-white" role="status"
                            style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>

                    <div class="errors text-danger text-center mt-3" id="errors"></div>
                </form>

            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"
    integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/js/user.js') }}"></script>

</html>
