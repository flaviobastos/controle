<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Pagamentos</title>
    <link rel="icon" href="{{ asset('icons/schedule.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>

<body>
    {{ $slot }}
</body>

<script>
    function showToast(icon, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-start",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        Toast.fire({
            icon: icon,
            title: title
        });
    }

    window.addEventListener('success', function() {
        showToast("success", "Operação executada com sucesso");
    });

    window.addEventListener('error', function() {
        showToast("error", "Não foi possível executar a operação");
    });
</script>

</html>
