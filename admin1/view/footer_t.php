<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy;<?php echo date("Y"); ?> -<a href="">SIMPANANQIU</a>.</strong> All rights reserved.
  </footer>


 
 <div class="floating-icon" id="tombol1"  data-toggle="modal" onclick="hide('custom-tabs-four-home')" data-target="#modal-lg">
  <div class="circle">
    <i class="fas fa-plus"></i>
  </div>
</div>
<script>
// Periksa URL halaman
if (window.location.href.indexOf("profile.php") > -1) {
  // Jika URL adalah "profile.php," sembunyikan elemen
  document.querySelector('#tombol1').style.display = "none";
}

if (window.location.href.indexOf("transaksi.php") > -1) {
  // Jika URL adalah "profile.php," sembunyikan elemen
  document.querySelector('#tombol1').style.bottom = "60px";
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Menampilkan tooltip saat halaman dimuat
    var tooltip = new bootstrap.Tooltip(document.querySelector('#tombol1'), {
        title: "Tambah Data",
        placement: "right",
        trigger: "manual"
    });
    tooltip.show();

    // Menghilangkan tooltip setelah 6 detik
    setTimeout(function () {
        tooltip.hide();
    }, 6000);

     var aset = new bootstrap.Tooltip(document.querySelector('#custom-tabs-two-tab'), {
        title: "Menampilkan Data",
        placement: "top",
        trigger: "manual"
    });
    aset.show();

    // Menghilangkan aset setelah 6 detik
    setTimeout(function () {
        aset.hide();
    }, 6000);
});
</script>

<!-- Tambahkan Bootstrap JS dan jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../users/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../users/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../users/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../users/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../users/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../users/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../users/plugins/jszip/jszip.min.js"></script>
<script src="../../users/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../users/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="../../users/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../users/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../users/plugins/moment/moment.min.js"></script>
<script src="../../users/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../users/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../users/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../users/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../users/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../users/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../users/plugins/dropzone/min/dropzone.min.js"></script>

<!-- SweetAlert2 -->
<!-- <script src="../../users/plugins/sweetalert2/sweetalert2.min.js"></script> -->
<!-- Toastr -->
<script src="../../users/plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE App -->
<script src="../../users/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../users/dist/js/demo.js"></script>
  <!-- pace-progress -->
<script src="../../users/plugins/pace-progress/pace.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
       "pageLength": 10,  // Tampilkan 10 baris per halaman
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [10, 25, 50, 100], 
       // Tampilkan opsi jumlah baris per halaman
      
    });
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
    $('#reservationdatetime_e').datetimepicker({ icons: { time: 'far fa-clock' } });

     $('#datetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })

</script>
</body>
</html>
