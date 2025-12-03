<!DOCTYPE html>
<html>

<head>
    <title>Laravel Mail</title>
</head>

<body>
    <p>{{ $data['name'] }} ({{ $data['email'] }}) has sent you a message through the contact form on the website. The
        message can be seen below.</p>
    <p>______________________________</p>
    <p>{!! nl2br(e($data['message'])) !!}</p>
    <p>______________________________</p>
</body>

</html>
