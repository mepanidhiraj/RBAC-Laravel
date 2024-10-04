<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Forbidden</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h1 class="text-danger">403 Forbidden</h1>
        <p class="lead">You do not have permission to access this page.</p>
        <a href="{{ route('admin.index') }}" class="btn btn-primary">Return to Dashboard</a>
    </div>
</body>
</html>
