@extends('layouts.dashboard')

@section('title')
  Pasien
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Pasien</h3>
        <ul class="breadcrumbs">
          <li class="nav-home">
            <a href="{{ route('dashboard') }}">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="{{ route('pasien.index') }}">Pasien</a>
          </li>
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <button id="createButton" type="button" class="btn btn-primary btn-round" data-bs-toggle="modal"
          data-bs-target="#pasienForm">
          Tambah Pasien
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pasiens as $pasien)
                    <tr>
                      <td>{{ $pasien->nama }}</td>
                      <td>{{ $pasien->nohp }}</td>
                      <td>{{ $pasien->alamat }}</td>
                      <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $pasien->id }}"
                          data-nama="{{ $pasien->nama }}" data-nohp="{{ $pasien->nohp }}"
                          data-alamat="{{ $pasien->alamat }}">
                          <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-nama="{{ $pasien->nama }}"
                          data-id="{{ $pasien->id }}">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  @include('pasien.form', ['pasien' => null])
@endsection

@section('script')
  <script>
    $("#basic-datatables").DataTable({});

    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('pasienForm'));

      // Edit Pasien
      const editButtons = document.querySelectorAll('.edit-btn');
      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Set form action to update
          const form = document.getElementById('formPasien');
          const formAction = "{{ route('pasien.update', ':id') }}".replace(':id', this.getAttribute(
            'data-id'));
          form.action = formAction;
          form.method = 'POST'

          // Add a hidden input for the PUT method
          if (!document.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
          }

          // Set form inputs for update
          document.getElementById('nama').value = this.getAttribute('data-nama');
          document.getElementById('nohp').value = this.getAttribute('data-nohp');
          document.getElementById('alamat').value = this.getAttribute('data-alamat');

          // Set hidden input for the edit ID
          document.getElementById('edit_id').value = this.getAttribute('data-id');

          // Change modal title for edit
          document.getElementById('pasienFormLabel').innerText = 'Edit Data';
          document.getElementById('submitBtn').innerText = 'Update';

          formPesanan = document.getElementById('formPesanan');
          formPesanan.hidden = true;
          let formElements = formPesanan.querySelectorAll('input, select, textarea');
          formElements.forEach(function(element) {
            element.disabled = true;
          });

          modal.show();
        });
      });

      // Create Pasien (Reset form for create)
      const createButton = document.getElementById('createButton');
      createButton.addEventListener('click', function() {
        const form = document.getElementById('formPasien');

        // Reset form values for a new entry
        form.reset();

        // Set form action to store (create)
        form.action = "{{ route('pasien.store') }}";
        form.method = 'POST';

        formPesanan = document.getElementById('formPesanan')
        formPesanan.hidden = false;
        let formElements = formPesanan.querySelectorAll('input, select, textarea');
        formElements.forEach(function(element) {
          element.disabled = false;
        });

        // Remove the _method input if it exists
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
          methodInput.remove();
        }

        // Change modal title for create
        document.getElementById('pasienFormLabel').innerText = 'Create Data';
        document.getElementById('submitBtn').innerText = 'Create';

        modal.show();
      });

      // Delete Pasien
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const pasienId = this.getAttribute('data-id');
          const pasienNama = this.getAttribute('data-nama');

          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Pasien '${pasienNama}' akan dihapus. Data tidak dapat dikembalikan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
          }).then((result) => {
            if (result.isConfirmed) {
              // Create a hidden form to submit the delete request
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = `/pasien/${pasienId}`;
              form.style.display = 'none';

              // Add CSRF and DELETE method inputs
              const csrfInput = document.createElement('input');
              csrfInput.name = '_token';
              csrfInput.value = '{{ csrf_token() }}';
              csrfInput.type = 'hidden';
              form.appendChild(csrfInput);

              const methodInput = document.createElement('input');
              methodInput.name = '_method';
              methodInput.value = 'DELETE';
              methodInput.type = 'hidden';
              form.appendChild(methodInput);

              // Append the form to the body and submit it
              document.body.appendChild(form);
              form.submit();
            }
          });
        });
      });
    });
  </script>
@endsection
