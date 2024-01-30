<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    body{
        width : 1056px;
        height : 816px;
        margin : 0px auto;
    }
    .container{
        display: flex;
        flex-wrap: wrap;
    }
    .card {
        width: 40%;
        height: 200px;
        border : 2px solid black;
        margin : 5px;
        padding-left: 10px;
    }
</style>

<body>
    <div class="container">
        <?php 
            for ($i=0; $i < count($data) ; $i++) { 
        ?>
            <div class="card">
                <h3><b>YTH.</b></h3>
                <h3>{{ $data[$i]['nama'] }}</h3>

                <h4>{{ $data[$i]['alamat'] }}</h4>

                <h3>UP : {{ $data[$i]['pic'] }} - {{ $data[$i]['telp'] }}</h3>
            </div>
            
        <?php }    ?>
    </div>
</body>
</html>