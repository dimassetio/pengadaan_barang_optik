<div class="modal fade" id="lensaForm" tabindex="-1" aria-labelledby="lensaFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lensaFormLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLensa" action="{{ route('lensa.store') }}" method="POST">
          @csrf
          <input type="hidden" id="edit_id" name="edit_id" value="">
          <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" class="form-control" id="merk" name="merk" required>
          </div>
          <div class="mb-3">
            <label for="jenis" class="form-label">Jenis</label>
            <input type="text" class="form-control" id="jenis" name="jenis" required>
          </div>
          <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran</label>
            <input type="text" class="form-control" id="ukuran" name="ukuran" required>
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
          </div>
          <div class="mb-3">
            <label for="penerima" class="form-label">Penerima</label>
            <input type="text" class="form-control" id="penerima" name="penerima" required>
          </div>
          <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
