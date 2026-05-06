<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
</head>
<body>

<h2>Verifikasi Email</h2>

<p>
    Kami sudah mengirim link verifikasi ke email kamu.
</p>

@if(session('message'))
    <p style="color:green">
        {{ session('message') }}
    </p>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <button type="submit">
        Kirim Ulang Email
    </button>
</form>

</body>
</html>