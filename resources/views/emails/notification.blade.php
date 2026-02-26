<!DOCTYPE html>
<html>
<head>
    <title>{{ $subjectStr }}</title>
</head>
<body>
    <h2>{{ $subjectStr }}</h2>
    <table border="1" cellpadding="5">
        @foreach($payload as $key => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                <td>{!! nl2br(e($value)) !!}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
