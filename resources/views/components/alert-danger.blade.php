<div class="alert alert-dismissible alert-danger d-flex align-items-center p-5">
    <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
    
    <div class="d-flex flex-column">
        {{ $slot }}
    </div>

    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
    </button>
</div>