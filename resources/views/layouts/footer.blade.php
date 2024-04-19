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
<form action="" method="post" id="deleteForm" style="display: none">
    @csrf
    @method('delete')
</form>

<!-- jQuery -->
<script src="{{ asset('assets/admin') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/admin') }}/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/admin') }}/js/demo.js"></script>

<script>
    var dataTable;
    $(function() {
        $(document).on('click', '.confirm-delete', function() {
            var deleteUrl = $(this).attr('data-url');
            if (confirm('Are you sure?')) {
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteForm').submit();
            }
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

        $('#check-all').click(function() {
            var rows = dataTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
        $('.bulk-action-btn').click(function() {
            handleBulkAction($(this).data('url'), $(this).data('action'));
        });
        function handleBulkAction(bulkUrl, action) {
            var selectedIds = [];
            $('.check-item:checked').each(function() {
                selectedIds.push($(this).val());
            });

            console.log('Selected IDs:', selectedIds);

            if (selectedIds.length === 0) {
                alert("{{ __('share.select_at_least_one_row') }}");
                return;
            }
            if (confirm('Are you sure you want to perform this action?')) {
                $.ajax({
                    url: bulkUrl,
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: action
                    },
                    success: function(response) {
                        dataTable.ajax.reload();
                        alert('Action successfully executed');
                    },
                    error: function(error) {
                        console.error('Error during action:', error);
                        alert('Error performing the action');
                    }
                });
            }
        }
    });
</script>
@stack('js')
</body>
</html>
