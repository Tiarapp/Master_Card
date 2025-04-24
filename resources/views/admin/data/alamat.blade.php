<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Customer</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('data.sync') }}" style="margin-bottom: 20px;margin-left: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <div class="row">            
            <!-- Modal -->
            <div class="modal fade" id="Customer">
                <div class="modal-dialog modal-xl">
                    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">List Customer</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body customer">
                            <div class="card-body">
                                <table class="table table-bordered" id="data_customer">
                                    <thead>
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Alamat Kirim</th>
                                            <th scope="col">Telp</th>
                                            <th scope="col">PIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($cust as $data) { ?>
                                            <tr class="modal-plan-list">
                                                <td>
                                                    <input type="hidden" class="form-control cust_id" value="{{ $data->Kode }}">
                                                    <button class="btn btn-success btn-insert-opi" type="button">Add</button>
                                                </td>
                                                <td>{{ $data->Nama }}</td>
                                                <td>{{ $data->AlamatKirim }}</td>
                                                <td>{{ $data->TelpKirim }}</td>
                                                <td>{{ $data->PIC }}</td>
                                                {{-- <td>{{ $data->AlamatKirim }}</td> --}}
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <button type="button" data-toggle="modal" data-target="#Customer" class="btn btn-success">
                Cari Customer <i class="fas fa-search"></i>
            </button>
        
            <button class="btn btn-primary" style="maring-left: 10px">
                <a href={{ route('sync_fa') }} style="margin-bottom: 20px; color: white"> Sync Nomer FA</a>  
            </button>
        </div>
        
        <form action="{{ route('cust.print') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>PIC</th>
                            <th>No Telp</th>
                        </thead>
                        <tbody id="plan-list"></tbody>
                    </table>
                </div> 
            </div>
            <div>
                {{-- <a href="{{ route('cust.print') }}"> --}}
                    <button type="submit" class="btn btn-primary">
                        Print
                    </button>
                {{-- </a> --}}
            </div>
        </form>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  <script>
    $("#modal-opi").ready(function(){
        var table = $("#data_customer").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_customer").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });
    });

    $(document).on("click", ".btn-insert-opi", function(e) {
        console.log("tes");
        cust_id = $(this).closest(".modal-plan-list").find('.cust_id').val();
        var url = "../cust/single/:id";
        url = url.replace(':id', cust_id);

        $.get(url, function(data) {

            var html = '';

            var json = (JSON.parse(data));

            console.log(json);
                    
            html += "<tr class='plan-list'>";
                html += "<td>";
                    html += "<input type='text' id='cust_id' name='cust_id["+ json.Kode.trim() +"]' value='"+ json.Kode.trim() +"' readonly>";
                html += "</td>";
                html += "<td>"+ json.Nama +"</td>";
                html += "<td>"+ json.AlamatKirim +"</td>";
                html += "<td>"+ json.PIC +"</td>";
                html += "<td>"+ json.TelpKirim +"</td>";
            html += "</tr>";
            $("#plan-list").append(html);
        });
        $("#Customer").modal("hide");
    });
  </script>

  @endsection