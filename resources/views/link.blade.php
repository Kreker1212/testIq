<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генератор ссылок</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        #table {
            margin-top: 10px ;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        form {
            padding: 15px 20px;

        }

        label {
            font-size: 20px;
            margin: 5px 10px 5px 0;
        }

        input {
            vertical-align: middle;
            margin: 5px 10px 5px 0;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            width: 300px;
        }

        button {
            font-size: 15px;
            padding: 10px 15px;
            background-color: #04AA6D;
            border: 1px solid #ddd;
            color: white;
            cursor: pointer;
            border-radius: 10px;
        }

        body{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<form id="urlForm">
    @csrf
    <label for="link">Введите URL:</label>
    <input type="text" id="link" name="link" required>
    <button type="button" onclick="shortenUrl()">Сократить</button>
</form>
<table id="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Сокращенна ссылка</th>
        <th>Полная ссылка</th>
    </tr>
    </thead>
    <tbody>
    @foreach($shortLinks as $link)
        <tr>
            <td id="id">{{$link->id}}</td>
            <td id="shortLink"><a id="shortLinkA" href="{{route('links.show', $link->code)}}"
                                  target="_blank">{{route('links.show', $link->code)}}</a>
            </td>
            <td id="link">{{$link->link}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    function shortenUrl() {
        const link = $('#link').val();

        $.ajax({
            url: "/links",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                link
            },
            success: function (response) {
                displayResult(response);
            },
            error: function () {
                displayResult('Ошибка при сокращении ссылки.');
            }
        });
    }

    function displayResult(response) {

        let tbodyRef = document.getElementById('table').getElementsByTagName('tbody')[0];

        let newRow = tbodyRef.insertRow();

        let id = newRow.insertCell();
        let shortLink = newRow.insertCell();
        let link = newRow.insertCell();

        let a = document.createElement('a');
        a.setAttribute("href", response.short_link);
        a.setAttribute("target", "_blank");
        shortLink.appendChild(a);

        let idText = document.createTextNode(response.link_id);
        let shortLinkText = response.short_link;
        let linkText = document.createTextNode(response.full_link);

        id.appendChild(idText);
        a.innerText += shortLinkText;
        link.appendChild(linkText);
    }
</script>
</body>
</html>
