@extends('layouts.dashboard')

@section('title')
  Pesanan
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Pesanan</h3>
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
            <a href="{{ route('pesanan.index') }}">Pesanan</a>
          </li>
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <button id="createButton" type="button" class="btn btn-primary btn-round" data-bs-toggle="modal"
          data-bs-target="#pesananForm">
          Tambah Pesanan
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
                    <th>No Pembelian</th>
                    <th>Pasien</th>
                    <th>Frame</th>
                    <th>Jenis Lensa</th>
                    <th>Ukuran</th>
                    <th>Tanggal Proses</th>
                    <th>Tanggal Selesai</th>
                    <th>Teknisi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pesanans as $pesanan)
                    <tr>
                      <td>{{ $pesanan->no_pembelian }}</td>
                      <td>{{ $pesanan->pasien->nama }}</td>
                      <td>{{ $pesanan->frame->kode }}</td>
                      <td>{{ $pesanan->lensa->jenis }}</td>
                      <td>{{ $pesanan->lensa->ukuran }}</td>
                      <td>{{ $pesanan->tanggal_proses->translatedFormat('d M Y') }}</td>
                      <td>{{ $pesanan->tanggal_selesai->translatedFormat('d M Y') }}</td>
                      <td>{{ $pesanan->teknisi }}</td>
                      <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $pesanan->id }}"
                          data-pesanan="{{ $pesanan }}">
                          <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                          data-no_pembelian="{{ $pesanan->no_pembelian }}" data-id="{{ $pesanan->id }}">
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
  @include('pesanan.form', ['pesanan' => null])
@endsection

@section('script')
  <script>
    $("#basic-datatables").DataTable({});

    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('pesananForm'));

      // Edit Pesanan
      const editButtons = document.querySelectorAll('.edit-btn');
      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Set form action to update
          const form = document.getElementById('formPesanan');
          const formAction = "{{ route('pesanan.update', ':id') }}".replace(':id', this.getAttribute(
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
          const pesananData = JSON.parse(this.getAttribute('data-pesanan'));
          console.log(pesananData);
          document.getElementById('no_pembelian').value = pesananData.no_pembelian;
          document.getElementById('pasien').value = pesananData.pasien_id;
          document.getElementById('frame').value = pesananData.frame_id;
          document.getElementById('jenis_lensa').value = pesananData.lensa.jenis;
          document.getElementById('lensa').value = pesananData.lensa_id;
          document.getElementById('tanggal_proses').value = pesananData.tanggal_proses.split('T')[0];
          document.getElementById('tanggal_selesai').value = pesananData.tanggal_selesai.split('T')[0];
          document.getElementById('teknisi').value = pesananData.teknisi;

          // Set hidden input for the edit ID
          document.getElementById('edit_id').value = this.getAttribute('data-id');

          // Change modal title for edit
          document.getElementById('pesananFormLabel').innerText = 'Edit Data';
          document.getElementById('submitBtn').innerText = 'Update';

          modal.show();
        });
      });

      // Create Pesanan (Reset form for create)
      const createButton = document.getElementById('createButton');
      createButton.addEventListener('click', function() {
        const form = document.getElementById('formPesanan');

        // Reset form values for a new entry
        form.reset();

        // Set form action to store (create)
        form.action = "{{ route('pesanan.store') }}";
        form.method = 'POST';

        // Remove the _method input if it exists
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
          methodInput.remove();
        }

        // Change modal title for create
        document.getElementById('pesananFormLabel').innerText = 'Create Data';
        document.getElementById('submitBtn').innerText = 'Create';

        modal.show();
      });

      // Delete Pesanan
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const pesananId = this.getAttribute('data-id');
          const pesananNoPembelian = this.getAttribute('data-no_pembelian');

          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Pesanan '${pesananNoPembelian}' akan dihapus. Data tidak dapat dikembalikan!`,
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
              form.action = `/pesanan/${pesananId}`;
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
