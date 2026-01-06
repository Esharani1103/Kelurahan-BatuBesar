<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>

<h1>Dashboard Admin</h1>

<p>Login sebagai: <b>{{ auth('admin')->user()->username }}</b></p>

<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>
