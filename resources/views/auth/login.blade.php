<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

        .login-box{
            background:white;
            padding:40px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            width:300px;
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

        a{
            text-decoration:none;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Login</h2>

    {{-- NOTIF SUKSES --}}
    @if(session('success'))
        <p style="color:green">
            {{ session('success') }}
        </p>
    @endif

    {{-- ERROR LOGIN --}}
    @if(session('error'))
        <p style="color:red">
            {{ session('error') }}
        </p>
    @endif

    {{-- FORM LOGIN --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email"
               name="email"
               placeholder="Email"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit">
            Login
        </button>
    </form>

    <br>

    <a href="{{ route('password.request') }}">
        Lupa Password?
    </a>

    <br><br>

    <a href="{{ route('register') }}">
        Belum punya akun? Register
    </a>

</div>

</body>
</html>