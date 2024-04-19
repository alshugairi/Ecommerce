<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        1.0
    </div>
    <!-- Default to the left -->
    <span>Copyright &copy;  <script>document.write(new Date().getFullYear());</script> <a href="#">{{ __('share.site_name') }}</a>.</span>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/admin') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/admin') }}/plugins/chart.js/Chart.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/admin') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>


<script src="{{ asset('assets/admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets/admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets/admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/admin') }}/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/admin') }}/js/demo.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var dataTable;
    $(function() {
        $(document).on('click','.confirm-delete', function () {
            var deleteUrl = $(this).attr('data-url');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').attr('action', deleteUrl);
                    $('#deleteForm').submit();
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#filterForm').submit(function (e){
            e.preventDefault();
            dataTable.ajax.reload();
        });
    });
</script>
@stack('js')
</body>
</html>
