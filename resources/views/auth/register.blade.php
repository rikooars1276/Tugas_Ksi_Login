<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

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

        .register-box{
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

        a{
            text-decoration:none;
        }
    </style>
</head>

<body>

<div class="register-box">

    <h2>Register</h2>

    {{-- ERROR VALIDASI --}}
    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text"
               name="name"
               placeholder="Nama"
               required>

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="email"
               name="email"
               placeholder="Email"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <input type="password"
               name="password_confirmation"
               placeholder="Konfirmasi Password"
               required>

        <button type="submit">
            Register
        </button>
    </form>

    <br>

    <a href="{{ route('login') }}">
        Sudah punya akun? Login
    </a>

</div>

</body>
</html>