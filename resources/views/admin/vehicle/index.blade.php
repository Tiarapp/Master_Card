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
          <h1 class="m-0">Vehicle History</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Vehicle History</li>
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
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <div class="card-body">
        <div class="row col-md-6 mb-3">
            <div class="col-md-2">
                <label for="filter-vehicle-number">Nomor Kendaraan :</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="nopol" placeholder="Enter Vehicle Number">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary cek">Cek</button>
            </div>
        </div>

        <table class="table table-bordered" id="data_colorcombine">
          <thead>
            <tr>
              <th scope="col">Nomer Kendaraan</th>
              <th scope="col">Sopir</th>
              <th scope="col">Tanggal Masuk</th>
              <th scope="col">Customer / Supplier</th>
              <th scope="col">Tujuan</th>
              <th scope="col">Tanggal Keluar 2</th>
              <th scope="col">Lama Proses</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vehicle as $data)
                <tr class="{{ $data->date_out ? 'table-success' : 'table-warning' }}">
                    <td>{{ $data->vehicle_number }}</td>
                    <td>{{ $data->driver_name }}</td>
                    <td>{{ $data->date_in }}</td>
                    <td>{{ $data->masterdata ? $data->masterdata->name : '' }}</td>
                    <td>{{ $data->masterdata ? $data->masterdata->city : '' }}</td>
                    <td>{{ $data->date_out ?? "Belum Check Out" }}</td>
                    <td>
                        @if($data->date_out)
                            @php
                                $totalMinutes = \Carbon\Carbon::parse($data->date_in)->diffInMinutes(\Carbon\Carbon::parse($data->date_out));
                                $days = intdiv($totalMinutes, 1440);
                                $hours = intdiv($totalMinutes % 1440, 60);
                                $minutes = $totalMinutes % 60;
                                $seconds = \Carbon\Carbon::parse($data->date_in)->diffInSeconds(\Carbon\Carbon::parse($data->date_out)) % 60;
                                $pad = fn($num) => str_pad($num, 2, '0', STR_PAD_LEFT);
                            @endphp
                            {{ $days }} hari - {{ $pad($hours) }} : {{ $pad($minutes) }} : {{ $pad($seconds) }}
                        @else
                            <span class="live-duration" data-datein="{{ \Carbon\Carbon::parse($data->date_in)->toIso8601String() }}"></span>
                        @endif
                    </td>
                    <td>{{ ucfirst($data->status) }}</td>
                    <td>
                        <button type="button" class="btn btn-info view-photos" data-id="{{ $data->id }}">View</button>
                        {{-- Add other action buttons if needed --}}
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>

        {{ $vehicle->appends(request()->query())->links() }}

        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add New Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <div class="form-group">
                                <label for="recipient-name" class="col-form-label">No Polisi :</label>
                                <input type="text" class="form-control" name="vehicle_number" id="no-polisi" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Sopir</label>
                            <input type="text" class="form-control" name="driver_name" id="driver-name" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Type </label>
                            <select class="custom-select type" name="type" id="tipe">
                                <option value="">Select Type</option>
                                <option value="customer">Customer</option>
                                <option value="supplier">Supplier</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Supplier / Customer</label>
                            <div class="input-group">
                                <select class="custom-select masterdata select2" name="masterdata_id" id="masterdata_id" style="width: 100%;" data-placeholder="Select Supplier / Customer">
                                    <option value=""></option>
                                    {{-- @foreach ($masterdata as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach --}}
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#masterdataCreateModal">+ Baru</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Tujuan</label>
                            <input type="text" class="form-control" name="destination" id="destination">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Status</label>
                            <select class="custom-select" name="status" id="status">
                                <option value="load">Load</option>
                                <option value="unload">Unload</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Gambar</label>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-take-photo">Ambil Foto (Kamera)</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-pick-gallery">Pilih dari Galeri</button>
                            </div>
                            <input type="file" id="image-camera" accept="image/*" capture="environment" class="d-none">
                            <input type="file" id="image-gallery" name="images[]" accept="image/*" multiple class="d-none">
                            <div id="imagePreview" class="d-flex flex-wrap mt-2"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit-btn">Save changes</button>
                        </div>
                    </form>

                    <div id="showPhotos" class="d-flex flex-wrap mt-2"></div>
                </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="photoPreviewModal" tabindex="-1" role="dialog" aria-labelledby="photoPreviewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="photoPreviewModalLabel">Preview Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center">
                <img id="photoPreviewImage" src="" alt="Vehicle Photo" style="max-width:100%; max-height:70vh;">
              </div>
              <div class="modal-footer">
                <a id="photoPreviewDownload" href="" download class="btn btn-primary"><i class="fas fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  @include('admin.vehicle.masterdata_create')
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  <script>
    $(document).ready(function() {
        $("#data_colorcombine").DataTable({
            order: [],
            paging: false,
            searching: false,
            info: false,
        });

        $("#nopol").on("keyup", function(e) {
            this.value = this.value.toUpperCase();
        });

        $(".select2").select2({
            dropdownParent: $("#createModal"),
            width: '100%'
        });

        // locks every field except the photo upload; disabled selects are re-enabled on submit so their values still post
        function setFormReadonly(isReadonly) {
            $("#no-polisi, #driver-name, #destination").prop("readonly", isReadonly);
            $("#status").prop("disabled", isReadonly);
        }

        $("#vehicleForm").on("submit", function() {
            $(this).find(":disabled").prop("disabled", false);
        });

        $(".cek").on("click", function() {
            const nopol = $("#nopol").val();
            // alert(nopol);
            if (nopol) {
                $.get(`/api/vehicle/${nopol}`, function(response) {
                    if (response.success) {
                        const data = response.data;
                        $("#vehicleForm").attr("action", "{{ route('vehicle.update', ':id') }}".replace(':id', data.id));
                        $("#form-method").val("PUT");
                        $("#submit-btn").text("Check-Out");
                        setFormReadonly(true);
                        $("#no-polisi").val(data.vehicle_number);
                        $("#driver-name").val(data.driver_name);
                        $("#tipe").val(data.type);

                        if (data.masterdata_id !== null) {
                            $.get(`/api/masterdata/id/${data.masterdata_id}`, function(masterdataResponse) {
                                if (masterdataResponse.success) {
                                    const masterdata = masterdataResponse.data;
                                    $("#masterdata_id").empty().append(
                                        `<option value="${masterdata.id}" selected>${masterdata.name}</option>`
                                    );
                                    $("#masterdata_id").trigger('change');
                                } else {
                                    alert("Failed to fetch master data by ID.");
                                }
                            }).fail(function() {
                                alert("An error occurred while fetching master data by ID.");
                            });
                        }

                        $("#destination").val(data.destination);
                        $("#status").val(data.status);
                        $("#createModalLabel").text("Vehicle Check-Out");
                        $("#createModal form").show();
                        $("#showPhotos").empty();
                        $("#createModal").modal("show");
                    } else {
                        $("#createModal form")[0].reset();
                        $("#vehicleForm").attr("action", "{{ route('vehicle.store') }}");
                        $("#form-method").val("POST");
                        $("#submit-btn").text("Check-In");
                        setFormReadonly(false);
                        selectedImageFiles = [];
                        syncImageInput();
                        $("#imagePreview").empty();
                        $("#no-polisi").val(nopol);
                        $("#createModalLabel").text("Add New Vehicle");
                        $("#createModal form").show();
                        $("#showPhotos").empty();
                        $("#createModal").modal("show");
                    }
                }).fail(function() {
                    alert("Terjadi kesalahan saat mengambil data kendaraan.");
                });
            } else {
                alert("Please enter a vehicle number.");
            }
        });

        $(".type").on("change", function() {
            const selectedType = $(this).val();
            const masterdataSelect = $("#masterdata_id");

            masterdataSelect.empty();
            if (selectedType == 'supplier') {
                $("#destination").prop('readonly', true);
            } else if (selectedType == 'customer') {
                $("#destination").val('').prop('readonly', false);
            }

            if (selectedType) {
                $.get(`/api/masterdata/${selectedType}`, function(response) {
                    if (response.success) {
                        masterdataSelect.append(
                            `<option value="">Select Type First</option>`
                        );
                        response.data.forEach(function(item) {
                            masterdataSelect.append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                        });
                        masterdataSelect.trigger('change');
                    } else {
                        alert("Failed to fetch master data." + selectedType);
                    }
                }).fail(function() {
                    alert("An error occurred while fetching master data.");
                });
            } else {
                masterdataSelect.append('<option value="">Select Type First</option>');
                masterdataSelect.trigger('change');
            }
        });

        $(".masterdata").on("change", function() {
            const selectedId = $(this).val();
            if (selectedId) {
                $.get(`/api/masterdata/id/${selectedId}`, function(response) {
                    if (response.success) {
                        const data = response.data;
                        $("#destination").val(data.city || '');
                    } else {
                        alert("Failed to fetch master data by ID.");
                    }
                }).fail(function() {
                    alert("An error occurred while fetching master data by ID.");
                });
            } else {
                $("#destination").val('');
            }
        });

        // holds files across repeated camera/gallery triggers since each trigger replaces input.files
        let selectedImageFiles = [];

        function syncImageInput() {
            const dataTransfer = new DataTransfer();
            selectedImageFiles.forEach(function(file) {
                dataTransfer.items.add(file);
            });
            $('#image-gallery')[0].files = dataTransfer.files;
        }

        function renderImagePreview() {
            const preview = $('#imagePreview');
            preview.empty();

            selectedImageFiles.forEach(function(file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    preview.append(
                    `<img src="${event.target.result}" alt="Preview Gambar" style="max-width:200px; margin-top:10px; margin-right:10px; border:1px solid #ddd; padding:5px;">`
                    );
                };

                reader.readAsDataURL(file);
            });
        }

        $('#btn-take-photo').on('click', function() {
            $('#image-camera').trigger('click');
        });

        $('#btn-pick-gallery').on('click', function() {
            $('#image-gallery').trigger('click');
        });

        $('#image-camera, #image-gallery').on('change', function(e) {
            selectedImageFiles = selectedImageFiles.concat(Array.from(e.target.files));
            // only clear the camera input's own value; #image-gallery holds the actual files posted to the server
            if (this.id !== 'image-gallery') {
                $(this).val('');
            }
            syncImageInput();
            renderImagePreview();
        });

        $(".view-photos").on("click", function() {
            const transactionId = $(this).data("id");
            $.get(`/api/vehicle/photos/${transactionId}`, function(response) {
                if (response.success) {
                    const photos = response.data;
                    let photoHtml = '';
                    photos.forEach(function(photo) {
                        const url = `/upload_vehicle/${photo.photo_path}`;
                        photoHtml += `
                            <div class="position-relative" style="margin:10px;">
                                <img src="${url}" alt="Vehicle Photo" class="photo-thumb" data-full="${url}" style="max-width:200px; border:1px solid #ddd; padding:5px; cursor:pointer;">
                                <a href="${url}" download class="btn btn-sm btn-light position-absolute" style="bottom:5px; right:5px;" title="Download"><i class="fas fa-download"></i></a>
                            </div>`;
                    });
                    $("#showPhotos").html(photoHtml);
                    $("#createModalLabel").text("Vehicle Photos");
                    $("#createModal form").hide();
                    $("#createModal").modal("show");
                } else {
                    alert("Failed to fetch vehicle photos.");
                }
            }).fail(function() {
                alert("An error occurred while fetching vehicle photos.");
            });
        });

        // opens the clicked thumbnail large in a lightbox modal with its own download link
        $("body").on("click", ".photo-thumb", function() {
            const fullUrl = $(this).data("full");
            $("#photoPreviewImage").attr("src", fullUrl);
            $("#photoPreviewDownload").attr("href", fullUrl);
            $("#photoPreviewModal").modal("show");
        });

        function updateLiveDurations() {
            $(".live-duration").each(function() {
                const dateIn = new Date($(this).data("datein"));
                const now = new Date();
                let totalMinutes = Math.floor((now - dateIn) / 60000);
                if (totalMinutes < 0) totalMinutes = 0;
                const days = Math.floor(totalMinutes / 1440);
                const hours = Math.floor((totalMinutes % 1440) / 60);
                const minutes = totalMinutes % 60;
                const seconds = Math.floor((now - dateIn) / 1000) % 60;
                const pad = (num) => String(num).padStart(2, "0");
                $(this).text(`${days} hari - ${pad(hours)} : ${pad(minutes)} : ${pad(seconds)}`);
            });
        }

        updateLiveDurations();
        setInterval(updateLiveDurations, 1000);
    });
  </script>

  @endsection
