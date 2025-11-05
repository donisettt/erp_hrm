<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ERP HRM')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>

    <div class="d-flex" id="wrapper">

        @include('layouts.components.sidebar')

        <div class="content-wrapper d-flex flex-column">

            @include('layouts.components.navbar')

            <main class="main-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 mb-0 text-dark-emphasis">@yield('title', 'Page')</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @yield('title', 'Page')
                                </li>
                            </ol>
                        </nav>
                    </div>

                    @yield('content')

                </div>
            </main>
            @include('layouts.components.footer')

        </div>
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4a55c7',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function confirmDelete(deleteId) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Saja!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + deleteId).submit();
                }
            });
        }
    </script>
</body>
</html>
