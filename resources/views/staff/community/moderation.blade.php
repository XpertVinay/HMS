@extends('layouts.portal')
@section('title', 'Community Moderation (Stage 1)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Community Moderation Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 1)</span></h2>
    <div class="flex gap-2">
        <button id="bulk-approve" class="btn-modern btn-success" style="display: none;"><i class='bx bx-check-double'></i> Bulk Approve</button>
        <button id="bulk-reject" class="btn-modern btn-danger" style="display: none;"><i class='bx bx-x'></i> Bulk Reject</button>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table ajax-table" id="community-table">
        <thead>
            <tr>
                <th class="no-sort w-10">
                    <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                </th>
                <th>Author</th>
                <th>Content</th>
                <th>Date</th>
                <th class="no-sort">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#community-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.community.moderation') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'member', name: 'member.username' },
                { data: 'content', name: 'content' },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Handle Select All
        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            toggleBulkButtons();
        });

        // Handle individual row checkbox
        $('#community-table').on('change', '.row-checkbox', function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }
            toggleBulkButtons();
        });

        function toggleBulkButtons() {
            var selectedCount = $('.row-checkbox:checked').length;
            if (selectedCount > 0) {
                $('#bulk-approve, #bulk-reject').show();
            } else {
                $('#bulk-approve, #bulk-reject').hide();
            }
        }

        // Bulk Actions
        $('#bulk-approve, #bulk-reject').on('click', function() {
            var action = $(this).attr('id') === 'bulk-approve' ? 'approve' : 'reject';
            var selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) return;

            if (confirm('Are you sure you want to bulk ' + action + ' ' + selectedIds.length + ' post(s)?')) {
                $.ajax({
                    url: "{{ route('staff.community.bulk') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: action,
                        post_ids: selectedIds
                    },
                    success: function(response) {
                        if(response.success) {
                            alert(response.message);
                            $('#select-all').prop('checked', false);
                            $('#bulk-approve, #bulk-reject').hide();
                            table.ajax.reload(null, false);
                        } else {
                            alert(response.message || 'An error occurred.');
                        }
                    },
                    error: function() {
                        alert('A server error occurred while processing your request.');
                    }
                });
            }
        });
    });
</script>
@endpush
