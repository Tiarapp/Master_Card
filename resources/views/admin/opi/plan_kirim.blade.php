@extends('admin.templates.partials.default')

<style>
.label {
  color: white;
}

.status {
  width: auto;
  height: auto;
  margin-top: 20px;
  text-align: center;
  padding: 8px;
  border-radius: 10%;
}

.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */
.other {background-color: #e7e7e7; color: black;} /* Gray */

.plan-kirim-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

.date-range {
    background-color: rgba(255,255,255,0.1);
    padding: 10px 15px;
    border-radius: 5px;
    display: inline-block;
}

.drag-handle {
    cursor: move;
    color: #6c757d;
}

.plan-row.dragging {
    opacity: 0.45;
}

.plan-row.drag-over-top {
    box-shadow: inset 0 3px 0 #0d6efd;
}

.plan-row.drag-over-bottom {
    box-shadow: inset 0 -3px 0 #0d6efd;
}

.drop-zone {
    transition: background-color .15s;
}

.drop-zone.drop-active {
    background-color: #e7f1ff;
}

.list-scroll {
    max-height: 480px;
    overflow-y: auto;
}

#available-list .col-num,
.th-num-available {
    display: none;
}

#plan-list .btn-add,
#available-list .btn-remove {
    display: none;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Plan Kirim OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('opinew') }}">OPI</a></li>
            <li class="breadcrumb-item active">Plan Kirim</li>
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

      <div class="plan-kirim-header">
        <h3 class="mb-2"><i class="fas fa-calendar-alt me-2"></i>Rencana Pengiriman OPI</h3>
        <small><i class="fas fa-info-circle me-2"></i>Status: Proses | Cari OPI di tanggal manapun, lalu drag & drop ke draft untuk memilih dan mengatur urutan</small>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-2 align-items-end">
            <div class="col-md-3">
              <label class="form-label mb-1 small">Nama Draft</label>
              <input type="text" id="draft-nama" class="form-control form-control-sm" maxlength="150" placeholder="mis. Plan Kirim 30 Okt 2026">
            </div>
            <div class="col-md-2">
              <label class="form-label mb-1 small">Tanggal Plan</label>
              <input type="date" id="draft-tgl" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label class="form-label mb-1 small">Catatan</label>
              <input type="text" id="draft-catatan" class="form-control form-control-sm" maxlength="1000">
            </div>
            <div class="col-md-4 d-flex gap-2 flex-wrap">
              <button type="button" class="btn btn-sm btn-primary" id="btn-save-draft" disabled>
                <i class="fas fa-save me-1"></i><span id="save-label">Simpan Draft</span>
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-new-draft" title="Mulai draft baru">
                <i class="fas fa-file me-1"></i>Baru
              </button>
              <button type="button" class="btn btn-sm btn-outline-danger" id="btn-clear-plan">
                <i class="fas fa-trash me-1"></i>Kosongkan
              </button>
            </div>
          </div>
          <div class="row g-2 align-items-end mt-1">
            <div class="col-md-5">
              <label class="form-label mb-1 small">Draft Tersimpan</label>
              <select id="draft-select" class="form-control form-control-sm">
                <option value="">-- pilih draft --</option>
              </select>
            </div>
            <div class="col-md-7 d-flex gap-2 flex-wrap">
              <button type="button" class="btn btn-sm btn-info" id="btn-load-draft"><i class="fas fa-folder-open me-1"></i>Buka</button>
              <button type="button" class="btn btn-sm btn-outline-danger" id="btn-delete-draft"><i class="fas fa-times me-1"></i>Hapus Draft</button>
              <form id="export-form" action="{{ route('opi.plan_kirim.export.selected') }}" method="POST" class="mb-0">
                @csrf
                <div id="export-ids"></div>
                <button type="submit" id="btn-export" class="btn btn-sm btn-success" disabled>
                  <i class="fas fa-file-excel me-1"></i>Export ke Excel
                </button>
              </form>
              <a href="{{ route('opinew') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke OPI
              </a>
            </div>
          </div>
          <div id="draft-info" class="small text-muted mt-2"></div>
        </div>
      </div>

      <!-- Draft Plan Kirim -->
      <div class="card shadow mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Draft Plan Kirim (<span id="plan-count">0</span> OPI)</h5>
          <small>Seret OPI dari daftar di bawah ke sini, lalu atur urutannya</small>
        </div>
        <div class="table-responsive">
          <table class="table align-middle table-striped table-hover mb-0" style="background-color: #fff;">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Drag</th>
                    <th scope="col" class="col-num">#</th>
                    <th scope="col">Tanggal Kirim</th>
                    <th scope="col">Customer</th>
                    <th scope="col">PO Customer</th>
                    <th scope="col">No. Kontrak</th>
                    <th scope="col">No OPI</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Qty Order</th>
                    <th scope="col">Gram</th>
                    <th scope="col">Ton</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="plan-list" class="drop-zone" data-list="plan">
                <tr class="empty-row">
                    <td colspan="14" class="text-center text-muted py-4">
                        <i class="fas fa-hand-pointer me-2"></i>Belum ada OPI di draft. Seret baris dari daftar OPI atau klik tombol <i class="fas fa-plus"></i>.
                    </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pencarian & Daftar OPI Tersedia -->
      <div class="card shadow">
        <div class="card-header bg-secondary text-white">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar OPI Proses (<span id="available-count">0</span> dimuat)</h5>
            <button type="button" class="btn btn-sm btn-light" id="btn-add-all" title="Masukkan semua OPI yang sedang dimuat">
              <i class="fas fa-angle-double-up me-1"></i>Masukkan Semua yang Dimuat
            </button>
          </div>
          <div class="row g-2">
            <div class="col-md-4">
              <input type="text" id="filter-q" class="form-control form-control-sm" placeholder="Cari No OPI / customer / PO / kontrak / kode & nama barang..." autocomplete="off">
            </div>
            <div class="col-md-3">
              <div class="input-group input-group-sm">
                <span class="input-group-text">Dari</span>
                <input type="date" id="filter-start" class="form-control" value="{{ date('Y-m-d') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="input-group input-group-sm">
                <span class="input-group-text">Sampai</span>
                <input type="date" id="filter-end" class="form-control">
              </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
              <button type="button" class="btn btn-sm btn-primary" id="btn-search"><i class="fas fa-search me-1"></i>Cari</button>
              <button type="button" class="btn btn-sm btn-outline-light" id="btn-reset-filter">Semua Tanggal</button>
            </div>
          </div>
        </div>
        <div class="table-responsive list-scroll">
          <table class="table align-middle table-striped table-hover mb-0" style="background-color: #fff;">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Drag</th>
                    <th scope="col" class="th-num-available">#</th>
                    <th scope="col">Tanggal Kirim</th>
                    <th scope="col">Customer</th>
                    <th scope="col">PO Customer</th>
                    <th scope="col">No. Kontrak</th>
                    <th scope="col">No OPI</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Qty Order</th>
                    <th scope="col">Gram</th>
                    <th scope="col">Ton</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="available-list" class="drop-zone" data-list="available"></tbody>
          </table>
          <div id="available-status" class="text-center text-muted py-3"></div>
        </div>
        <div class="card-footer text-center">
          <button type="button" class="btn btn-outline-primary btn-sm" id="btn-load-more" style="display:none;">
            <i class="fas fa-chevron-down me-1"></i>Muat lebih banyak
          </button>
        </div>
      </div>

      <!-- Ringkasan Draft -->
      <div class="card mt-4">
        <div class="card-header bg-light">
          <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan Draft Plan Kirim</h5>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col"><h4 class="text-primary" id="sum-opi">0</h4><small class="text-muted">Total OPI</small></div>
            <div class="col"><h4 class="text-success" id="sum-qty">0</h4><small class="text-muted">Total Quantity (pcs)</small></div>
            <div class="col"><h4 class="text-warning" id="sum-ton">0.000</h4><small class="text-muted">Total Tonnage (ton)</small></div>
            <div class="col"><h4 class="text-info" id="sum-cust">0</h4><small class="text-muted">Unique Customers</small></div>
            <div class="col"><h4 class="text-warning" id="sum-items">0</h4><small class="text-muted">Unique Items</small></div>
            <div class="col"><h4 class="text-secondary" id="sum-avg">0.000</h4><small class="text-muted">Avg Tonnage/OPI</small></div>
          </div>
        </div>
      </div>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@section('javascripts')
<script>
(function initPlanKirim() {
    const planList = document.getElementById('plan-list');
    const availableList = document.getElementById('available-list');
    const searchUrl = @json(route('opi.plan_kirim.search'));

    const filterQ = document.getElementById('filter-q');
    const filterStart = document.getElementById('filter-start');
    const filterEnd = document.getElementById('filter-end');
    const statusBox = document.getElementById('available-status');
    const loadMoreBtn = document.getElementById('btn-load-more');

    let draggedRow = null;
    let page = 1;
    let loading = false;
    let requestSeq = 0;

    const rowsOf = (list) => Array.from(list.querySelectorAll('tr.plan-row'));
    const planIds = () => new Set(rowsOf(planList).map((row) => row.dataset.id));

    // Sisipkan sesuai urutan tanggal kirim + No OPI
    const insertBySort = (list, row) => {
        const key = row.dataset.sort;
        const next = rowsOf(list).find((r) => r.dataset.sort > key);
        list.insertBefore(row, next || null);
    };

    const refresh = () => {
        const planRows = rowsOf(planList);
        planRows.forEach((row, i) => {
            row.querySelector('.row-number').textContent = i + 1;
        });

        const emptyRow = planList.querySelector('.empty-row');
        if (emptyRow) {
            emptyRow.style.display = planRows.length ? 'none' : '';
        }

        document.getElementById('plan-count').textContent = planRows.length;
        document.getElementById('available-count').textContent = rowsOf(availableList).length;

        let qty = 0, kg = 0;
        const customers = new Set();
        const items = new Set();
        planRows.forEach((row) => {
            qty += parseFloat(row.dataset.qty) || 0;
            kg += parseFloat(row.dataset.kg) || 0;
            customers.add(row.dataset.customer);
            items.add(row.dataset.kode);
        });
        const ton = kg / 1000;
        document.getElementById('sum-opi').textContent = planRows.length;
        document.getElementById('sum-qty').textContent = Math.round(qty).toLocaleString('en-US');
        document.getElementById('sum-ton').textContent = ton.toFixed(3);
        document.getElementById('sum-cust').textContent = customers.size;
        document.getElementById('sum-items').textContent = items.size;
        document.getElementById('sum-avg').textContent = (planRows.length ? ton / planRows.length : 0).toFixed(3);

        const exportIds = document.getElementById('export-ids');
        exportIds.innerHTML = '';
        planRows.forEach((row) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = row.dataset.id;
            exportIds.appendChild(input);
        });
        document.getElementById('btn-export').disabled = planRows.length === 0;
        if (typeof updateSaveState === 'function') {
            updateSaveState();
        }
    };

    // Muat OPI dari server (bertahap), OPI yang sudah ada di draft tidak ditampilkan lagi
    const loadAvailable = async (reset) => {
        if (loading && !reset) {
            return;
        }
        const seq = ++requestSeq;
        loading = true;

        if (reset) {
            page = 1;
            availableList.innerHTML = '';
            loadMoreBtn.style.display = 'none';
            refresh();
        }
        statusBox.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat data...';

        const params = new URLSearchParams({ page });
        if (filterQ.value.trim()) params.set('q', filterQ.value.trim());
        if (filterStart.value) params.set('start', filterStart.value);
        if (filterEnd.value) params.set('end', filterEnd.value);

        try {
            const response = await fetch(searchUrl + '?' + params.toString(), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
            });
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            const result = await response.json();
            if (seq !== requestSeq) {
                return;
            }

            const template = document.createElement('template');
            template.innerHTML = result.html.trim();
            const inPlan = planIds();
            Array.from(template.content.querySelectorAll('tr.plan-row')).forEach((row) => {
                if (!inPlan.has(row.dataset.id)) {
                    availableList.appendChild(row);
                }
            });

            page = result.next_page;
            loadMoreBtn.style.display = result.has_more ? '' : 'none';
            statusBox.textContent = rowsOf(availableList).length ? '' : 'Tidak ada OPI status Proses yang cocok dengan pencarian.';
        } catch (error) {
            if (seq === requestSeq) {
                statusBox.innerHTML = '<span class="text-danger">Gagal memuat data. Coba klik Cari lagi.</span>';
            }
        } finally {
            if (seq === requestSeq) {
                loading = false;
                refresh();
            }
        }
    };

    const clearMarks = () => {
        document.querySelectorAll('.drag-over-top, .drag-over-bottom').forEach((el) => {
            el.classList.remove('drag-over-top', 'drag-over-bottom');
        });
        document.querySelectorAll('.drop-active').forEach((el) => el.classList.remove('drop-active'));
    };

    [planList, availableList].forEach((list) => {
        list.addEventListener('dragstart', (event) => {
            const row = event.target.closest('tr.plan-row');
            if (!row) {
                return;
            }
            draggedRow = row;
            row.classList.add('dragging');
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', row.dataset.id);
        });

        list.addEventListener('dragend', () => {
            if (draggedRow) {
                draggedRow.classList.remove('dragging');
            }
            draggedRow = null;
            clearMarks();
        });

        list.addEventListener('dragover', (event) => {
            if (!draggedRow) {
                return;
            }
            event.preventDefault();
            clearMarks();
            list.classList.add('drop-active');

            const target = event.target.closest('tr.plan-row');
            if (target && target !== draggedRow) {
                const rect = target.getBoundingClientRect();
                target.classList.add(event.clientY > rect.top + rect.height / 2 ? 'drag-over-bottom' : 'drag-over-top');
            }
        });

        list.addEventListener('drop', (event) => {
            if (!draggedRow) {
                return;
            }
            event.preventDefault();

            const target = event.target.closest('tr.plan-row');
            const row = draggedRow;
            clearMarks();

            if (list === availableList) {
                insertBySort(availableList, row);
            } else if (target && target !== row) {
                const rect = target.getBoundingClientRect();
                const after = event.clientY > rect.top + rect.height / 2;
                list.insertBefore(row, after ? target.nextSibling : target);
            } else if (!target) {
                list.appendChild(row);
            }
            refresh();
        });

        list.addEventListener('click', (event) => {
            const row = event.target.closest('tr.plan-row');
            if (!row) {
                return;
            }
            if (event.target.closest('.btn-add')) {
                planList.appendChild(row);
                refresh();
            } else if (event.target.closest('.btn-remove')) {
                insertBySort(availableList, row);
                refresh();
            }
        });
    });

    document.getElementById('btn-search').addEventListener('click', () => loadAvailable(true));
    loadMoreBtn.addEventListener('click', () => loadAvailable(false));

    let debounce = null;
    filterQ.addEventListener('input', () => {
        clearTimeout(debounce);
        debounce = setTimeout(() => loadAvailable(true), 400);
    });
    [filterStart, filterEnd].forEach((input) => input.addEventListener('change', () => loadAvailable(true)));

    document.getElementById('btn-reset-filter').addEventListener('click', () => {
        filterStart.value = '';
        filterEnd.value = '';
        loadAvailable(true);
    });

    document.getElementById('btn-add-all').addEventListener('click', () => {
        rowsOf(availableList).forEach((row) => planList.appendChild(row));
        refresh();
    });

    document.getElementById('btn-clear-plan').addEventListener('click', () => {
        rowsOf(planList).forEach((row) => insertBySort(availableList, row));
        refresh();
    });

    // ===== Simpan / buka draft di database =====
    const routes = {
        list: @json(route('opi.plan_kirim.draft.list')),
        store: @json(route('opi.plan_kirim.draft.store')),
        show: @json(url('/admin/opi/plan_kirim/drafts')),
    };
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const draftSelect = document.getElementById('draft-select');
    const draftNama = document.getElementById('draft-nama');
    const draftTgl = document.getElementById('draft-tgl');
    const draftCatatan = document.getElementById('draft-catatan');
    const draftInfo = document.getElementById('draft-info');
    const saveBtn = document.getElementById('btn-save-draft');
    let currentDraftId = null;

    const api = async (url, options = {}) => {
        const response = await fetch(url, Object.assign({
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
            },
        }, options));
        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
            throw new Error(firstError || data.message || ('HTTP ' + response.status));
        }
        return data;
    };

    const updateSaveState = () => {
        saveBtn.disabled = rowsOf(planList).length === 0;
        document.getElementById('save-label').textContent = currentDraftId ? 'Simpan Perubahan' : 'Simpan Draft';
    };

    const loadDraftList = async (selectId) => {
        const result = await api(routes.list);
        draftSelect.innerHTML = '<option value="">-- pilih draft --</option>';
        result.drafts.forEach((d) => {
            const option = document.createElement('option');
            option.value = d.id;
            option.textContent = d.nama + ' (' + d.jumlah + ' OPI, ' + d.updated_at + ')';
            draftSelect.appendChild(option);
        });
        if (selectId) {
            draftSelect.value = selectId;
        }
    };

    const resetDraft = () => {
        rowsOf(planList).forEach((row) => insertBySort(availableList, row));
        currentDraftId = null;
        draftNama.value = '';
        draftTgl.value = '';
        draftCatatan.value = '';
        draftSelect.value = '';
        draftInfo.textContent = '';
        refresh();
    };

    saveBtn.addEventListener('click', async () => {
        const nama = draftNama.value.trim();
        if (!nama) {
            draftNama.focus();
            alert('Nama draft wajib diisi.');
            return;
        }
        saveBtn.disabled = true;
        try {
            const result = await api(routes.store, {
                method: 'POST',
                body: JSON.stringify({
                    id: currentDraftId,
                    nama: nama,
                    tgl_plan: draftTgl.value || null,
                    catatan: draftCatatan.value || null,
                    ids: rowsOf(planList).map((row) => row.dataset.id),
                }),
            });
            currentDraftId = result.id;
            await loadDraftList(result.id);
            draftInfo.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Draft "' + result.nama.replace(/</g, '&lt;') + '" tersimpan (' + result.jumlah + ' OPI).</span>';
        } catch (error) {
            draftInfo.innerHTML = '<span class="text-danger">Gagal menyimpan: ' + error.message.replace(/</g, '&lt;') + '</span>';
        } finally {
            updateSaveState();
        }
    });

    document.getElementById('btn-load-draft').addEventListener('click', async () => {
        if (!draftSelect.value) {
            return;
        }
        if (rowsOf(planList).length && !confirm('Draft yang sedang tampil akan diganti. Lanjutkan?')) {
            return;
        }
        try {
            const result = await api(routes.show + '/' + draftSelect.value);
            rowsOf(planList).forEach((row) => insertBySort(availableList, row));

            const template = document.createElement('template');
            template.innerHTML = result.html.trim();
            const loadedIds = new Set();
            Array.from(template.content.querySelectorAll('tr.plan-row')).forEach((row) => {
                loadedIds.add(row.dataset.id);
                // Hindari duplikat jika OPI yang sama sedang ada di daftar pencarian
                const dup = availableList.querySelector('tr.plan-row[data-id="' + row.dataset.id + '"]');
                if (dup) {
                    dup.remove();
                }
                planList.appendChild(row);
            });

            currentDraftId = result.id;
            draftNama.value = result.nama;
            draftTgl.value = result.tgl_plan || '';
            draftCatatan.value = result.catatan || '';
            draftInfo.innerHTML = result.skipped
                ? '<span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>' + result.skipped + ' OPI tidak dimuat karena statusnya bukan Proses lagi.</span>'
                : '';
            refresh();
        } catch (error) {
            draftInfo.innerHTML = '<span class="text-danger">Gagal membuka draft: ' + error.message.replace(/</g, '&lt;') + '</span>';
        }
    });

    document.getElementById('btn-delete-draft').addEventListener('click', async () => {
        if (!draftSelect.value || !confirm('Hapus draft tersimpan ini?')) {
            return;
        }
        const deletedId = parseInt(draftSelect.value, 10);
        try {
            await api(routes.show + '/' + deletedId, { method: 'DELETE' });
            if (currentDraftId === deletedId) {
                currentDraftId = null;
            }
            await loadDraftList();
            draftInfo.textContent = 'Draft dihapus.';
            updateSaveState();
        } catch (error) {
            draftInfo.innerHTML = '<span class="text-danger">Gagal menghapus: ' + error.message.replace(/</g, '&lt;') + '</span>';
        }
    });

    document.getElementById('btn-new-draft').addEventListener('click', () => {
        if (rowsOf(planList).length && !confirm('Draft yang sedang tampil akan dikosongkan. Lanjutkan?')) {
            return;
        }
        resetDraft();
    });

    loadDraftList().catch(() => {});

    refresh();
    loadAvailable(true);
})();
</script>
@endsection
@endsection
