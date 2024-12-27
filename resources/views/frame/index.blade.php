@extends('layouts.dashboard')

@section('title')
  Frame
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Frame</h3>
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
            <a href="{{ route('frame.index') }}">Frame</a>
          </li>
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <button id="createButton" type="button" class="btn btn-primary btn-round" data-bs-toggle="modal"
          data-bs-target="#frameForm">
          Tambah Frame
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
                    <th>Kode</th>
                    <th>Warna</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                    <th>Penerima</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($frames as $frame)
                    <tr>
                      <td>{{ $frame->kode }}</td>
                      <td>{{ $frame->warna }}</td>
                      <td>{{ $frame->quantity }}</td>
                      <td>{{ $frame->tanggal_masuk->translatedFormat('d M Y') }}</td>
                      <td>{{ $frame->penerima }}</td>
                      <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $frame->id }}"
                          data-kode="{{ $frame->kode }}" data-warna="{{ $frame->warna }}"
                          data-quantity="{{ $frame->quantity }}" data-tanggal_masuk="{{ $frame->tanggal_masuk }}"
                          data-penerima="{{ $frame->penerima }}">
                          <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-kode="{{ $frame->kode }}"
                          data-id="{{ $frame->id }}">
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
  @include('frame.form', ['frame' => null])
@endsection

@section('script')
  <script>
    $("#basic-datatables").DataTable({});

    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('frameForm'));

      // Edit Frame
      const editButtons = document.querySelectorAll('.edit-btn');
      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Set form action to update
          const form = document.getElementById('formFrame');
          const formAction = "{{ route('frame.update', ':id') }}".replace(':id', this.getAttribute(
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
          document.getElementById('kode').value = this.getAttribute('data-kode');
          document.getElementById('warna').value = this.getAttribute('data-warna');
          document.getElementById('quantity').value = this.getAttribute('data-quantity');
          document.getElementById('tanggal_masuk').value = this.getAttribute('data-tanggal_masuk');
          document.getElementById('penerima').value = this.getAttribute('data-penerima');

          // Set hidden input for the edit ID
          document.getElementById('edit_id').value = this.getAttribute('data-id');

          // Change modal title for edit
          document.getElementById('frameFormLabel').innerText = 'Edit Data';
          document.getElementById('submitBtn').innerText = 'Update';

          modal.show();
        });
      });

      // Create Frame (Reset form for create)
      const createButton = document.getElementById('createButton');
      createButton.addEventListener('click', function() {
        const form = document.getElementById('formFrame');

        // Reset form values for a new entry
        form.reset();

        // Set form action to store (create)
        form.action = "{{ route('frame.store') }}";
        form.method = 'POST';

        // Remove the _method input if it exists
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
          methodInput.remove();
        }

        // Change modal title for create
        document.getElementById('frameFormLabel').innerText = 'Create Data';
        document.getElementById('submitBtn').innerText = 'Create';

        modal.show();
      });

      // Delete Frame
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const frameId = this.getAttribute('data-id');
          const frameKode = this.getAttribute('data-kode');

          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Frame '${frameKode}' akan dihapus. Data tidak dapat dikembalikan!`,
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
              form.action = `/frame/${frameId}`;
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
