<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body {
            padding : 10px 30px;
            /* border: 1px solid black; */
            width: 210mm;
            height: 140mm;
        }
        p {
            margin-bottom: 0px;
        }

        textarea {
            overflow: hidden;
            height: auto;
            width: 250px;
            resize: none;
        }

        .detail-barang {
            padding: 0px 8px 5px 8px;
            text-align: center;
            font-size: 10px;
        }

        .font-detail {
            font-size: 10px;
        }
        .font-judul {
            font-size: 16px;
        }
        .title {
            text-align: center;
            width: 100%;
        }
        .info {
            display: inline-flex;
            width: 100%;
            margin-bottom: 10px;
        }

        .terbilang {
            width: 50%;
            margin-top: 10px;
            margin-right: 10px;
        }

        .nominal {
            width: 50%;
            margin-top: 10px;
        }

        .customer {
            width: 55%;
            margin-right: 10px;
        }

    </style>
</head>

<body>
    <div>
        <p class="font-judul"><strong>PT. SARANA PACKAGING AGRAPANA</strong></p>
        <p class="font-detail">DS. KEMBANGBAHU, KEC. MANTUP, KAB. LAMONGAN</p>
        <p class="font-detail">0821-4037-4626 / 0859-3225-6038</p>
    </div>
    <div class="title">
        <p class="font-judul"><strong>FAKTUR</strong></p>
        <br>
    </div>
    <div class="info">
        <div class="customer">
            <table>
                <tr>
                    <td><p class="font-detail">Nama Customer</p></td>
                    <td><p class="font-detail">:</p></td>
                    <td><p class="font-detail">PT. SINAR KARYA DUTA ABADI</p></td>
                </tr>
                <tr>
                    <td class="font-detail" style="vertical-align: top">Alamat</td>
                    <td class="font-detail" style="vertical-align: top">:</td>
                    <td>
                        <textarea class="font-detail" name="" id="" cols="40" rows="3" style="border-style: none; height: auto;">SENTRA NIAGA PURI INDAH BLOK T2/24 RT.002 RW.002 KEMBANGAN - KEMBANGAN SELATAN JAKARTA BARAT - DKI</textarea>
                        <p class="font-detail">JAKARTA RAYA</p>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td><p class="font-detail">Surat Jalan</p></td>
                    <td><p class="font-detail">:</p></td>
                    <td><p class="font-detail">PT. SINAR KARYA DUTA ABADI</p></td>
                </tr>
                <tr>
                    <td class="font-detail" style="vertical-align: top">Faktur No.</td>
                    <td class="font-detail" style="vertical-align: top">:</td>
                    <td class="font-detail">
                        <strong>FA003/I/25</strong>
                    </td>
                </tr>
                <tr>
                    <td class="font-detail" style="vertical-align: top">Tanggal</td>
                    <td class="font-detail" style="vertical-align: top">:</td>
                    <td>
                        <p class="font-detail">JAKARTA RAYA</p>
                    </td>
                </tr>
                <tr>
                    <td class="font-detail" style="vertical-align: top">Pembayaran</td>
                    <td class="font-detail" style="vertical-align: top">:</td>
                    <td>
                        <p class="font-detail">90 hari / 02-04-2025</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="border-bottom: 2px">
        <div style="outline-style: double; outline-color: black"></div>
        <table style="width: 100%; border-bottom-width: 1px" class="barang">
            <tr>
                <th class="detail-barang" colspan="5"></th>
                <th class="detail-barang" colspan="4">Discount</th>
                <th class="detail-barang"></th>
                <th class="detail-barang"></th>
            </tr>
            <tr style="border-bottom-width: 2px; border-color: black">
                <th class="detail-barang" style="text-align: left">Kode Brg / Jenis Barang</th>
                <th class="detail-barang">Sat</th>
                <th class="detail-barang">Crt</th>
                <th class="detail-barang">Ert</th>
                <th class="detail-barang">Harga</th>
                <th class="detail-barang">1</th>
                <th class="detail-barang">2</th>
                <th class="detail-barang">3</th>
                <th class="detail-barang">4</th>
                <th class="detail-barang">Disc</th>
                <th class="detail-barang">Jumlah</th>
            </tr>
            <tr>
                <td class="detail-barang" style="text-align: left; padding-left: 5px">
                    <p>LDE.01.01.S50.35887.002</p>
                    <p>BOX 60X60 ARNA SOLITARE MTP EXP T 8.4 MM</p>
                </td>
                <td class="detail-barang">PCS</td>
                <td class="detail-barang">0</td>
                <td class="detail-barang">21.600</td>
                <td class="detail-barang">1.518,00</td>
                <td class="detail-barang">0.0</td>
                <td class="detail-barang">0.0</td>
                <td class="detail-barang">0.0</td>
                <td class="detail-barang">0.0</td>
                <td class="detail-barang">0.0</td>
                <td class="detail-barang">32,788,800.00</td>
            </tr>
        </table>
        <div style="outline-style: double; outline-color: black"></div>
    </div>
    <div class="info">
        <div class="terbilang">
            <p class="font-detail">Terbilang :</p>
            <p class="font-detail" style="margin-left: 5px">
                Tiga puluh enam juta tiga ratus sembilan puluh lima ribu lima ratus enam puluh delapan rupiah
            </p>
            <br>

            <div class="font-detail" style="border: 2px solid black; width: 100%; padding: 5px">
                <p>PEMBAYARAN KE REKENING :</p>
                <p>PT. SARANA PACKAGING AGRAPANA</p>
                <p>PEMBAYARAN DIANGGAP LUNAS APABILA CEK/GIRO TELAH CAIR</p>
                <br>
                <p>DANAMON</p>
                <p>0077.0017.6220</p>
            </div>

        </div>
        <div class="nominal">
            <table style="float: right">
                <tr>
                    <td class="font-detail">Jumlah Harga</td>
                    <td></td>
                    <td>   </td>
                    <td class="font-detail" style="text-align: right">32,788,800.00</td>
                </tr>
                <tr>
                    <td class="font-detail">Potongan Harga</td>
                    <td></td>
                    <td></td>
                    <td class="font-detail" style="text-align: right">0.00</td>
                </tr>
                <tr>
                    <td class="font-detail">DPP</td>
                    <td></td>
                    <td></td>
                    <td class="font-detail" style="text-align: right">3,606,768.00</td>
                </tr>
                <tr>
                    <td class="font-detail">PPN = 11% X DPP</td>
                    <td></td>
                    <td></td>
                    <td class="font-detail" style="text-align: right">3,606,768.00</td>
                </tr>
                <tr>
                    <td class="font-detail">PPH 22</td>
                    <td></td>
                    <td></td>
                    <td class="font-detail" style="text-align: right">0.00</td>
                </tr>
                <tr>
                    <td class="font-detail" style="padding-right: 30px"><strong>JUMLAH YANG HARUS DIBAYAR</strong></td>
                    <td ></td>
                    <td></td>
                    <td class="font-detail" style="text-align: right">36,395,568.00</td>
                </tr>
                {{-- TTD --}}
                <tr>
                    <td colspan="4" style="text-align: center"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center"></td>
                </tr>
                <tr>
                    <td class="font-detail" colspan="4" style="text-align: center">PT. SARANA PACKAGING AGRAPANA</td>
                </tr>
                <tr>
                    <td class="font-detail" colspan="4" style="text-align: center">S.E. & O</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>