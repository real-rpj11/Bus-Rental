<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Mail</title>
</head>
<body>
    <h1>Title: {{ $details['title']}}</h1>
    <p>Client Id: {{$details['client_id']}}</p>
    <p>Bus Id: {{$details['bus_id']}}</p>
    <p>Start Date: {{$details['start_date']}}</p>
    <p>End Date: {{$details['end_date']}}</p>
    <p>Price: {{$details['price']}}</p>
    <p>Payment: {{$details['payment']}}</p>
    <p>Status: {{$details['status']}}</p>

    <p>Thank You!!</p>
</body>
</html>