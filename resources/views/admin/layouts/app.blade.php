<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.table-container { max-height:600px; overflow:auto; }
thead th { position:sticky; top:0; z-index:10; background:#f3f4f6; }

.input-box{
width:100%;
border:2px solid #e5e7eb;
border-radius:0.5rem;
padding:0.5rem;
font-size:0.875rem;
}

.pagination-container nav{
display:flex;
justify-content:center;
gap:5px;
padding:15px;
}
</style>

</head>

<body class="bg-gray-100 p-4 md:p-8">

@yield('content')

</body>
</html>