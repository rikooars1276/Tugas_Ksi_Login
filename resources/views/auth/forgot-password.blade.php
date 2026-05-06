<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>

    <style>
        body{
            margin:0;
            padding:0;
            height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            font-family:Arial, sans-serif;
            background:#f5f5f5;
        }

        .forgot-box{
            background:white;
            padding:40px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            width:320px;
        }

        input{
            width:100%;
            padding:10px;
            margin-top:10px;
            margin-bottom:15px;
        }

        button{
            width:100%;
            padding:10px;
            cursor:pointer;
        }
    </style>
</head>

<body>

<div class="forgot-box">

    <h2>Lupa Password</h2>

    {{-- NOTIF BERHASIL --}}
    @if(session('status'))
        <p style="color:green">
            {{ session('status') }}
        </p>
    @endif

    {{-- ERROR --}}
    @error('email')
        <p style="color:red">
            {{ $message }}
        </p>
    @enderror

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <input type="email"
               name="email"
               placeholder="Masukkan Email"
               required>

        <button type="submit">
            Kirim Link Reset
        </button>
    </form>

</div>

</body>
</html>