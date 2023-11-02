<!-- Pastikan Anda telah menyertakan jQuery dan Bootstrap di halaman HTML Anda -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<div class="form-group">
    <label for="datepicker">Tanggal dan Waktu:</label>
    <div class="input-group date" id="datetimepicker">
        <input type="text" class="form-control" id="datepicker">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<script>
$(function () {
    $('#datepicker').datetimepicker({
        showClose: true, // Tampilkan tombol tutup
        showTodayButton: true, // Tampilkan tombol "Hari Ini"
        allowInputToggle: true, // Aktifkan tampilan kalender saat input diklik
        format: 'YYYY-MM-DD HH:mm:ss' // Sesuaikan format tanggal dan waktu sesuai kebutuhan
    });
});
</script>
