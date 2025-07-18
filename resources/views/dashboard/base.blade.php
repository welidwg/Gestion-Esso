<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <title> {{ env('APP_NAME', 'Gestion Esso') }} -
        @section('title')
        @show
    </title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css' rel='stylesheet' />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@4.1.0/cdn.min.js"></script>
</head>



<body id="page-top">
    <div id="backdrop">
        <div class="text-center loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", () => {
            $("#backdrop").fadeOut()
        })
    </script>
    <div id="wrapper">
        @include('dashboard/sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" class="text-size-md">
                @include('dashboard/navbar')
                <div class="p-2 p-md-3">
                    @section('content')
                    @show
                </div>
            </div>
            @include('dashboard/footer')
        </div>
        {{-- <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a> --}}
    </div>
</body>

<script src="{{ asset('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap/js/theme.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"
    integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $.extend(true, $.fn.dataTable.defaults, {
        "order": [],

        "language": {
            "search": "Rechercher:",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "decimal": ".",
            "emptyTable": "Aucun ligne ",
            "info": "",
            "infoFiltered": "",
            "infoEmpty": "",
            "lengthMenu": "",

        },

    });
    $("input").addClass("shadow-none text-size-md");
</script>

</html>
