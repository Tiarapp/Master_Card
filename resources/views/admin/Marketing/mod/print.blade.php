<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @media print {
            @page {
                /* size: A5 portrait; Untuk orientasi tegak */
                size: A5 landscape; Untuk orientasi mendatar
                /* margin: 10mm; Margin kertas */
            }

            body {
                width: 100%;
                margin: 0;
                padding: 0;
                font-size: 12px; /* Sesuaikan ukuran font jika perlu */
            }

            /* Sembunyikan elemen yang tidak diperlukan untuk cetak */
            .no-print {
                display: none;
            }

            .mod {
                text-transform: uppercase;
                font-size: 11px;
                text-align: center;
            }
        }

    </style>
</head>
<body>
    <div style="border: 1px solid black" class="mod">
        <h3>Marketing Order</h3>
    </div>
    <div>
         
    </div>
    <div class="no-print">
        <p>Bagian ini tidak akan muncul saat dicetak.</p>
    </div>
      
</body>
</html>