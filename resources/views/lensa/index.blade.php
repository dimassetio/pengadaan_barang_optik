@extends('layouts.dashboard')

@section('title')
  Lensa
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Lensa</h3>
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
            <a href="{{ route('lensa.index') }}">Lensa</a>
          </li>
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <button id="createButton" type="button" class="btn btn-primary btn-round" data-bs-toggle="modal"
          data-bs-target="#lensaForm">
          Tambah Lensa
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
                    <th>Merk</th>
                    <th>Jenis</th>
                    <th>Ukuran</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                    <th>Penerima</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($lensas as $lensa)
                    <tr>
                      <td>{{ $lensa->merk }}</td>
                      <td>{{ $lensa->jenis }}</td>
                      <td>{{ $lensa->ukuran }}</td>
                      <td>{{ $lensa->quantity }}</td>
                      <td>{{ $lensa->tanggal_masuk->translatedFormat('d M Y') }}</td>
                      <td>{{ $lensa->penerima }}</td>
                      <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $lensa->id }}"
                          data-merk="{{ $lensa->merk }}" data-jenis="{{ $lensa->jenis }}"
                          data-ukuran="{{ $lensa->ukuran }}" data-quantity="{{ $lensa->quantity }}"
                          data-tanggal_masuk="{{ $lensa->tanggal_masuk }}" data-penerima="{{ $lensa->penerima }}">
                          <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-merk="{{ $lensa->merk }}"
                          data-id="{{ $lensa->id }}">
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
  @include('lensa.form', ['lensa' => null])
@endsection

@section('script')
  <script>
    $("#basic-datatables").DataTable({});

    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('lensaForm'));

      // Edit Lensa
      const editButtons = document.querySelectorAll('.edit-btn');
      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Set form action to update
          const form = document.getElementById('formLensa');
          const formAction = "{{ route('lensa.update', ':id') }}".replace(':id', this.getAttribute(
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
          document.getElementById('merk').value = this.getAttribute('data-merk');
          document.getElementById('jenis').value = this.getAttribute('data-jenis');
          document.getElementById('ukuran').value = this.getAttribute('data-ukuran');
          document.getElementById('quantity').value = this.getAttribute('data-quantity');
          document.getElementById('tanggal_masuk').value = this.getAttribute('data-tanggal_masuk');
          document.getElementById('penerima').value = this.getAttribute('data-penerima');

          // Set hidden input for the edit ID
          document.getElementById('edit_id').value = this.getAttribute('data-id');

          // Change modal title for edit
          document.getElementById('lensaFormLabel').innerText = 'Edit Data';
          document.getElementById('submitBtn').innerText = 'Update';

          modal.show();
        });
      });

      // Create Lensa (Reset form for create)
      const createButton = document.getElementById('createButton');
      createButton.addEventListener('click', function() {
        const form = document.getElementById('formLensa');

        // Reset form values for a new entry
        form.reset();

        // Set form action to store (create)
        form.action = "{{ route('lensa.store') }}";
        form.method = 'POST';

        // Remove the _method input if it exists
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
          methodInput.remove();
        }

        // Change modal title for create
        document.getElementById('lensaFormLabel').innerText = 'Create Data';
        document.getElementById('submitBtn').innerText = 'Create';

        modal.show();
      });

      // Delete Lensa
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const lensaId = this.getAttribute('data-id');
          const lensaMerk = this.getAttribute('data-merk');

          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Lensa '${lensaMerk}' akan dihapus. Data tidak dapat dikembalikan!`,
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
              form.action = `/lensa/${lensaId}`;
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
