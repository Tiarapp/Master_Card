<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')

<?php
  $periode = '';
  $hasil = '';

  for ($i=0; $i < count($all_periode) ; $i++) { 
    if ($periode == '') {
      $periode = $all_periode[$i];
    } else {    
      $periode = $periode.'/'.$all_periode[$i];
    }
  }
  for ($i=0; $i < count($data) ; $i++) { 
    if ($hasil == '') {
      $hasil = $data[$i]->kirim;
    } else {    
      $hasil = $hasil.'/'.$data[$i]->kirim;
    }
  }
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $jumlah_kontrak }}</h3>

              <p>Kontrak Baru {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($tonase,2,',','.') }}<sup style="font-size: 20px">   Kg</sup></h3>

              <p>Estimasi Tonase {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ number_format($realisasi,2,',','.') }}<sup style="font-size: 20px">   Kg</sup></h3>

              <p>Tonase Pengiriman {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      @if (Auth::user()->divisi_id == 3 || Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 13)
        
      {{-- <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Chart Penjualan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body" >
              <div class="chart">
                <input type="hidden" id="periode" value="{{ $periode }}">
                <input type="hidden" id="tonase" value="{{ $hasil }}">
                <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
      </div> --}}
        @if (Auth::user()->divisi_id == 13)
          <div class="col-md-6 p-3 text-left  border bg-gray-300">
            <h5 class="mb-0">Terdapat {{ count($kontrak_open) }} Kontrak yang berstatus OPEN</h5>
            <a href="">Details ..</a>
          </div>
        @endif
      @endif
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<script>
  $(function () {

    var all_periode = document.getElementById('periode').value;
    var tonase = document.getElementById('tonase').value;
    var periode = all_periode.split("/")
    var data = tonase.split("/")

    // var per

    var areaChartData = {
      labels  : periode,
      datasets: [
        // {
        //   label               : 'Digital Goods',
        //   backgroundColor     : 'rgba(60,141,188,0.9)',
        //   borderColor         : 'rgba(60,141,188,0.8)',
        //   pointRadius          : false,
        //   pointColor          : '#3b8bba',
        //   pointStrokeColor    : 'rgba(60,141,188,1)',
        //   pointHighlightFill  : '#fff',
        //   pointHighlightStroke: 'rgba(60,141,188,1)',
        //   data                : [28, 48, 40, 19, 86, 27, 90]
        // },
        {
          label               : 'Penjualan',
          barPercentage       : 0.8,
          backgroundColor     : 'rgba(255, 0, 0, 0.8)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : true,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#000',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : data
        },
      ]
    }

    // var areaChartOptions = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: true
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : true,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : true,
    //       }
    //     }]
    //   }
    // }
    // //-------------
    // //- LINE CHART -
    // //--------------
    // var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    // var lineChartOptions = $.extend(true, {}, areaChartOptions)
    // var lineChartData = $.extend(true, {}, areaChartData)
    // lineChartData.datasets[0].fill = false;
    // // lineChartData.datasets[1].fill = false;
    // lineChartOptions.datasetFill = false

    // var lineChart = new Chart(lineChartCanvas, {
    //   type: 'line',
    //   data: lineChartData,
    //   options: lineChartOptions
    // })

    var barChartCanvas = $('#lineChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[0] = temp0

    var barChartOptions = {
      locale  : 'en-US',
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })
</script>
@endsection