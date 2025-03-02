@extends("dashboard.layouts")
@section('title', 'Kendaraan')
@section("title-content", "Kendaraan Page")

@section("content")
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="w-100 row">
          <!-- Judul -->
          <div class="col-xs-6">
            <h4>Kelola Kendaraan</h4>
          </div>


          
          <div class="col-xs mx-1">
            <input type="search" class="form-control" id="search-input">
          </div>

          <!-- Dropdown Order -->
          <div class="col-xs">
            <select id="order-selector" class="form-control">
              <option value="asc">Terlama</option>
              <option value="desc">Terbaru</option>
            </select>
          </div>

          <!-- Dropdown Limit -->
          <div class="col-xs mx-1">
            <select id="limit-selector" class="form-control">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
          </div>

          <!-- Tombol Tambah Kendaraan -->
          <div class="col-xs ml-auto">
            <button type="button" class="btn btn-primary" id="add-data" data-toggle="modal" data-target="#modal-add">
              Tambah Kendaraan
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <thead>
              <tr>
                <th>Nomor Kendaraan</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer text-right">

       <nav class="d-inline-block" id="pagination-nav">
          <ul class="pagination mb-0">
            <li class="page-item" id="first-page">
              <a class="page-link" href="#" aria-label="First">
                <i class="fas fa-angle-double-left"></i>
              </a>
            </li>
            <li class="page-item" id="prev-page">
              <a class="page-link" href="#" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
              </a>
            </li>
            <div id="page-numbers" class="d-flex"></div>
            <li class="page-item" id="next-page">
              <a class="page-link" href="#" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
              </a>
            </li>
            <li class="page-item" id="last-page">
              <a class="page-link" href="#" aria-label="Last">
                <i class="fas fa-angle-double-right"></i>
              </a>
            </li>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</div>



@endsection

@section("modal")

<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form class="w-100" id="form-add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Kendaraan</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nopol" class="form-label">TNKB</label>
            <input type="text" class="form-control" name="nopol" id="nopol" required>
          </div>
          <div class="form-group">
            <label for="brand" class="form-label">Brand Kendaraan</label>
            <input type="text" class="form-control" name="brand_kendaraan" id="brand" required>
          </div>
          <div class="form-group">
            <label for="model" class="form-label">Model Kendaraan</label>
            <input type="text" class="form-control" name="model_kendaraan" id="model" required>
          </div>
          <div class="form-group">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="number" step="1" min="1" class="form-control" name="kapasitas" id="kapasitas" required>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="gambar" name="gambar[]" accept="image/jpg,image/jpeg,image/png">
            <label class="custom-file-label" for="gambar">Pilih Gambar</label>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke">
          <button type="reset" class="btn btn-secondary btn-shadow" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-shadow">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form class="w-100" id="form-edit">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Data Kendaraan</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="ref">
          <div class="form-group">
            <label for="nopol-edit" class="form-label">TNKB</label>
            <input type="text" class="form-control" name="nopol" id="nopol-edit" required>
          </div>
          <div class="form-group">
            <label for="brand-edit" class="form-label">Brand Kendaraan</label>
            <input type="text" class="form-control" name="brand_kendaraan" id="brand-edit" required>
          </div>
          <div class="form-group">
            <label for="model-edit" class="form-label">Model Kendaraan</label>
            <input type="text" class="form-control" name="model_kendaraan" id="model-edit" required>
          </div>
          <div class="form-group">
            <label for="kapasitas-edit" class="form-label">Kapasitas</label>
            <input type="number" step="1" min="1" class="form-control" name="kapasitas" id="kapasitas-edit" required>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="gambar-edit" name="gambar[]" accept="image/jpg,image/jpeg,image/png">
            <label class="custom-file-label" for="gambar-edit">Pilih Gambar</label>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke">
          <button type="reset" class="btn btn-secondary btn-shadow" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-shadow">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section("css")

@endsection

@section("javascript")
<script>
  let DATA = [];

  function __loadData(params = CURRENT_PARAMS) {

    CURRENT_PARAMS = params;

    // Update URL
    updateUrlParams(params);


    $.ajax({
      method: "GET",
      url: "{{route('kendaraan.loaddata')}}",
      data: {
        page: params.page,
        limit: params.limit,
        order: params.order,
        search: params.search
      },
      beforeSend: function(e) {
        Swal.fire({
          title: "Memuat data...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        })
      },
      success: function(e) {
        let html = "";
        if (e.success === true) {
          if (e.data.length > 0) {
            DATA = [];
            e.data.forEach((item) => {
              DATA[item.ref] = item
              html += `<tr>
                      <td>${item.nopol}</td>
                      <td>${item.brand_kendaraan}</td>
                      <td>${item.model_kendaraan}</td>
                      <td>${item.kapasitas}</td>
                      <td>
                        <div class="badge badge-${item.aktif == 1 ? "success" : "danger"}">${item.aktif == 1 ? "Aktif" : "Tidak Aktif"}</div>
                      </td>
                      <td>
                        <button href="#" class="btn btn-warning btn-edit" data-target="${item.ref}">Ubah</button>
                        <button href="#" class="btn btn-danger btn-destroy" data-target="${item.ref}">Hapus</button>
                      </td>
                    </tr>`
            })
          } else {
            html += `<tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
              </tr>`
          }
          updatePagination(e.pagination);
          $("table.table tbody").html(html)
        }
        Swal.close()
      },
      error: function(e) {
        errorAPI(e)
      }
    })
  }

  function __submitAddHandler(e) {
    e.preventDefault();

    const formData = new FormData(e.target)

    $.ajax({
      method: "POST",
      url: '{{route("kendaraan.store")}}',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function(data, textStatus, jqXHR) {
        Swal.fire({
          title: "Mohon tunggu...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        })
      },
      success: function(data, textStatus, jqXHR) {
        Swal.fire({
          icon: "success",
          title: 'Berhasil menambahkan data',
        }).then(() => {
          if (data.success === true) {
            __loadData()
            $(".modal").modal("hide")
          }
        })
      },
      error: function(data, textStatus, jqXHR) {
        errorAPI(data)
      }
    })

  }

  function __editHandler() {
    const ref = $(this).data("target");
    const dataTarget = DATA[ref]
    $("#modal-edit").off("show.bs.modal").on("show.bs.modal", function(e) {
      console.log(dataTarget)
      $("#form-edit input[name=nopol]").val(dataTarget.nopol)
      $("#form-edit input[name=brand_kendaraan]").val(dataTarget.brand_kendaraan)
      $("#form-edit input[name=model_kendaraan]").val(dataTarget.model_kendaraan)
      $("#form-edit input[name=kapasitas]").val(dataTarget.kapasitas)
      $("#form-edit input[name=ref]").val(dataTarget.ref)
    });
    $("#modal-edit").modal("show")
  }


  function __submitUpdateHandler(e) {
    e.preventDefault();

    const formData = new FormData(e.target)
    formData.append("_method", "PATCH");

    // Contoh di JavaScript
    const ref = formData.get("ref");
    const url = "{{ route('kendaraan.update', ['kendaraan' => '__REF__']) }}".replace('__REF__', ref);

    $.ajax({
      method: "POST",
      url,
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function(data, textStatus, jqXHR) {
        Swal.fire({
          title: "Mohon tunggu...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        })
      },
      success: function(data, textStatus, jqXHR) {
        Swal.fire({
          icon: "success",
          title: 'Berhasil mengubah data',
        }).then(() => {
          if (data.success === true) {
            __loadData()
            $(".modal").modal("hide")
          }
        })
      },
      error: function(data, textStatus, jqXHR) {
        errorAPI(data)
      }
    })

  }

  function __destroyHandler() {
    const ref = $(this).data("target");
    const dataTarget = DATA[ref]
    Swal.fire({
      title: "Apakah anda yakin ingin menghapus?",
      showCancelButton: true,
      confirmButtonText: "Ya, Yakin",
      cancelButtonText: "Tidak",
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          method: "DELETE",
          url: `${SEGMENT_URL}/${dataTarget.ref}`,
          data: {
            ref: dataTarget.ref
          },
          beforeSend: function(data, textStatus, jqXHR) {
            Swal.fire({
              title: "Mohon tunggu...",
              allowOutsideClick: false,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading();
              }
            })
          },
          success: function(data, textStatus, jqXHR) {
            Swal.fire({
              icon: "success",
              title: 'Berhasil menghapus data',
            }).then(() => {
              if (data.success === true) {
                __loadData()
                $(".modal").modal("hide")
              }
            })
          },
          error: function(data, textStatus, jqXHR) {
            errorAPI(data)
          }
        })
      }
    });
  }

  $("document").ready(function() {

    __loadData()

    $(document).on("submit", "#form-add", __submitAddHandler)
    $(document).on("submit", "#form-edit", __submitUpdateHandler)

    $(document).on("click", ".btn-edit", __editHandler)
    $(document).on("click", ".btn-destroy", __destroyHandler)

    $("#modal-add, #modal-edit").on("hide.bs.modal", function(e) {
      $("#form-add, #form-edit").trigger("reset")
    })

  });
</script>
@endsection