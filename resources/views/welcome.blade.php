<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ env('APP_NAME') }} - Se connecter</title>
    <link rel="stylesheet" href="{{ asset('assets/fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/login.css') }}" />

</head>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" /> --}}

<body class="container">
    <div class="bg-flou"></div>
    <div class="row d-flex flex-column vh-100 justify-content-center align-items-center w-100 form-container mx-auto">
        <div class="col-md-6">
            <div class="p">

                <form class="user bg-light p-4 rounded-4 shadow">
                    <div class="text-center">
                        <h4 class="text-dark  fw-bolder mb-4">Se connecter</h4>
                    </div>
                    <div class="mb-3"><input id="exampleInputEmail" class="form-control form-control-user"
                            type="text" aria-describedby="emailHelp" placeholder="Votre nom d'utilisateur"
                            name="username" /></div>
                    <div class="mb-3">
                        <input id="" class="form-control form-control-user" type="password"
                            placeholder="Mot de passe" name="password" />
                    </div>
                    <div class="mb-3">
                        {{-- <div class="custom-control custom-checkbox small">
                            <div class="form-check"><input id="formCheck-1"
                                    class="form-check-input custom-control-input" type="checkbox" /><label
                                    class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label>
                            </div>
                        </div> --}}
                    </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Connexion <i
                            class="fal fa-sign-in-alt"></i></button>
                    <hr />
                </form>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>

</html>
