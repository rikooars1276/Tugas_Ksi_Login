<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>

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

        .reset-box{
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

<div class="reset-box">

    <h2>Reset Password</h2>

    {{-- ERROR --}}
    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden"
               name="token"
               value="{{ $token }}">

        <input type="email"
               name="email"
               value="{{ request()->email }}"
               required>

        <input type="password"
               name="password"
               placeholder="Password Baru"
               required>

        <input type="password"
               name="password_confirmation"
               placeholder="Konfirmasi Password"
               required>

        <button type="submit">
            Ubah Password
        </button>
    </form>

</div>

</body>
</html>