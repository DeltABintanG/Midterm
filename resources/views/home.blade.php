<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    @auth
    <h1>youre login</h1>
    <form action="/logout" method="POST">
        @csrf
        <button>Log out</button>
    </form>
    @else
    <h1>Hello From Laravel</h1>
    <form action="/registration">
        <button>Register Now</button>
    </form>
    @endauth
    
</body>
</html>