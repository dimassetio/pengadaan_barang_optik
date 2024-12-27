<div class="modal fade" id="pesananForm" tabindex="-1" aria-labelledby="pesananFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pesananFormLabel">Tambah Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPesanan" action="{{ route('pesanan.store') }}" method="POST">
          @csrf
          <input type="hidden" id="edit_id" name="edit_id" value="">

          <!-- No Pembelian -->
          <div class="mb-3">
            <label for="no_pembelian" class="form-label">No Pembelian</label>
            <input type="text" class="form-control" id="no_pembelian" name="no_pembelian" required>
          </div>

          <!-- Pasien Dropdown -->
          <div class="mb-3">
            <label for="pasien" class="form-label">Pasien</label>
            <select class="form-control" id="pasien" name="pasien_id" required>
              <option value="">Pilih Pasien</option>
              @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
              @endforeach
            </select>
          </div>

          <!-- Frame Dropdown -->
          <div class="mb-3">
            <label for="frame" class="form-label">Frame</label>
            <select class="form-control" id="frame" name="frame_id" required>
              <option value="">Pilih Frame</option>
              @foreach ($frames as $frame)
                <option value="{{ $frame->id }}">{{ $frame->kode }} - {{ $frame->warna }}</option>
              @endforeach
            </select>
          </div>

          <!-- Jenis Lensa Dropdown -->
          <div class="mb-3">
            <label for="jenis_lensa" class="form-label">Jenis Lensa</label>
            <select class="form-control" id="jenis_lensa" name="jenis_lensa" required>
              <option value="">Pilih Jenis Lensa</option>
              @foreach ($lensas as $lensa)
                <option value="{{ $lensa->jenis }}">{{ $lensa->jenis }}</option>
              @endforeach
            </select>
          </div>

          <!-- Ukuran Lensa Dropdown -->
          <div class="mb-3">
            <label for="lensa" class="form-label">Ukuran Lensa</label>
            <select class="form-control" id="lensa" name="lensa_id" required>
              <option value="">Pilih Ukuran Lensa</option>
              @foreach ($lensas as $lensa)
                <option value="{{ $lensa->id }}">{{ $lensa->merk }} - {{ $lensa->ukuran }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tanggal Proses -->
          <div class="mb-3">
            <label for="tanggal_proses" class="form-label">Tanggal Proses</label>
            <input type="date" class="form-control" id="tanggal_proses" name="tanggal_proses" required>
          </div>

          <!-- Tanggal Selesai -->
          <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
          </div>

          <!-- Teknisi -->
          <div class="mb-3">
            <label for="teknisi" class="form-label">Teknisi</label>
            <input type="text" class="form-control" id="teknisi" name="teknisi" required>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const jenisLensaDropdown = document.getElementById('jenis_lensa');
    const lensaDropdown = document.getElementById('lensa');

    // Event listener for jenis_lensa dropdown
    jenisLensaDropdown.addEventListener('change', function() {
      const selectedJenis = this.value;

      // Reset and disable the lensa dropdown if no jenis is selected
      lensaDropdown.disabled = !selectedJenis;
      lensaDropdown.innerHTML = '<option value="">Pilih Ukuran Lensa</option>';

      if (selectedJenis) {
        // Filter options based on the selected jenis
        const allLensaOptions = @json($lensas); // Pass PHP array to JavaScript
        const filteredLensaOptions = allLensaOptions.filter(lensa => lensa.jenis === selectedJenis);

        // Populate the lensa dropdown with filtered options
        filteredLensaOptions.forEach(lensa => {
          const option = document.createElement('option');
          option.value = lensa.id;
          option.textContent = `${lensa.merk} - ${lensa.ukuran}`;
          lensaDropdown.appendChild(option);
        });
      }
    });
  });
</script>
