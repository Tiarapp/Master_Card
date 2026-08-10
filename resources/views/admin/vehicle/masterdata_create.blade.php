<div class="modal fade" id="masterdataCreateModal" tabindex="-1" role="dialog" aria-labelledby="masterdataCreateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="masterdataCreateModalLabel">Tambah Customer / Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="masterdataCreateAlert" class="alert alert-danger d-none"></div>
        <form id="masterdataCreateForm">
          <div class="form-group">
            <label for="masterdata-type" class="col-form-label">Type</label>
            <select class="custom-select" name="type" id="masterdata-type">
              <option value="customer">Customer</option>
              <option value="supplier">Supplier</option>
            </select>
          </div>
          <div class="form-group">
            <label for="masterdata-name" class="col-form-label">Nama</label>
            <input type="text" class="form-control" name="name" id="masterdata-name">
          </div>
          <div class="form-group">
            <label for="masterdata-city" class="col-form-label">Kota</label>
            <input type="text" class="form-control" name="city" id="masterdata-city">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="masterdataCreateSubmit">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
      // pre-fills the new masterdata type from the vehicle form's currently selected type
      $("#masterdataCreateModal").on("show.bs.modal", function() {
          $("#masterdataCreateAlert").addClass("d-none").text("");
          $("#masterdataCreateForm")[0].reset();
          const currentType = $("#tipe").val();
          if (currentType) {
              $("#masterdata-type").val(currentType);
          }
      });

      $("#masterdataCreateSubmit").on("click", function() {
          const payload = {
              name: $("#masterdata-name").val(),
              city: $("#masterdata-city").val(),
              type: $("#masterdata-type").val(),
          };

          $.post("{{ route('masterdata.store') }}", payload, function(response) {
              if (response.success) {
                  const item = response.data;

                  // keep the vehicle form's type in sync and add the new option as selected
                  $("#tipe").val(item.type);
                  $("#masterdata_id").append(
                      `<option value="${item.id}" selected>${item.name}</option>`
                  );

                  $("#destination").val(item.city);

                  $("#masterdataCreateModal").modal("hide");
              } else {
                  $("#masterdataCreateAlert").removeClass("d-none").text("Failed to save data.");
              }
          }).fail(function(xhr) {
              const message = xhr.responseJSON && xhr.responseJSON.message
                  ? xhr.responseJSON.message
                  : "An error occurred while saving data.";
              $("#masterdataCreateAlert").removeClass("d-none").text(message);
          });
      });
  });
</script>
