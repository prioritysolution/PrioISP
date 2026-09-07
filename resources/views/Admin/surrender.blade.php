@extends('Dashboard.Layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <style>
                .filter-label {
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #495057;
                    text-transform: uppercase;
                    margin-bottom: 6px;
                }

                .btn-cyan {
                    background-color: #00c4cc;
                    border-color: #00c4cc;
                    color: white;
                    font-weight: 500;
                }

                .btn-cyan:hover {
                    background-color: #00aeb5;
                    color: white;
                }

                .table th,
                .table td {
                    vertical-align: middle;
                    padding: 10px 16px;
                    border-bottom: 1px solid #f1f1f1;
                    font-size: 0.85rem;
                }

                .table-header {
                    font-size: 0.8rem;
                    font-weight: 700;
                    color: #495057;
                    background-color: #f8f9fa !important;
                }

                .modal-info-row {
                    display: flex;
                    justify-content: space-between;
                    padding: 6px 0;
                    border-bottom: 1px solid #f1f1f1;
                    font-size: 0.875rem;
                }

                .modal-info-row:last-of-type {
                    border-bottom: none;
                }

                .modal-info-label {
                    color: #6c757d;
                    font-weight: 600;
                    text-transform: uppercase;
                    font-size: 0.75rem;
                }

                .modal-info-value {
                    font-weight: 600;
                    color: #1a2942;
                }

                .dataTables_length {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    padding-top: 0 !important;
                    margin-top: 0 !important;
                }

                .dataTables_length label {
                    margin-bottom: 0;
                    line-height: 1;
                }
            </style>

            <div class="page-title-banner shadow-sm"
                style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
                Customer Surrender
            </div>

            {{-- Search Panel --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="filter-label">A/C No</label>
                            <input type="text" id="srch-account" class="form-control" placeholder="Enter Account No...">
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">User ID</label>
                            <input type="text" id="srch-userid" class="form-control" placeholder="Enter User ID...">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Cust Code</label>
                            <input type="text" id="srch-code" class="form-control" placeholder="Cust Code...">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Name</label>
                            <input type="text" id="srch-name" class="form-control" placeholder="Customer Name...">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-search">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            <button class="btn btn-secondary w-100" id="btn-reset">
                                <i class="fas fa-times me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Results Card --}}
            <div class="card border-0 shadow-sm d-none" id="result-card">
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="surrender-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Cust Code</th>
                                    <th>Cust Name</th>
                                    <th>User ID</th>
                                    <th>Account No</th>
                                    <th>Contact No</th>
                                    <th>Counter</th>
                                    <th>Package</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="surrender-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="surrenderModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-user-slash me-2"></i> Update Customer Status
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light rounded p-3 mb-4">
                        <div class="modal-info-row">
                            <span class="modal-info-label">Cust Code</span>
                            <span class="modal-info-value" id="s-show-code"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Cust Name</span>
                            <span class="modal-info-value" id="s-show-name"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">User ID</span>
                            <span class="modal-info-value" id="s-show-userid"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Account No</span>
                            <span class="modal-info-value" id="s-show-account"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Current Status</span>
                            <span class="modal-info-value text-danger" id="s-show-status"></span>
                        </div>
                    </div>
                    <form id="surrenderForm">
                        <input type="hidden" id="s-cust-id" name="Cust_Id">
                        <div>
                            <label class="filter-label">New Status <span class="text-danger">*</span></label>
                            <select name="Status" id="s-status" class="form-select">
                                <option value="">-- Select Status --</option>
                                @foreach ($statuses as $st)
                                    <option value="{{ $st->Opt_Id }}">{{ $st->Opt_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-cyan" id="btn-surrender-update">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#surrender-table')) {
                $('#surrender-table').DataTable().destroy();
            }
            $('#surrender-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [9]
                }]
            });

            var statusLabels = {
                1: 'Active',
                2: 'InActive',
                3: 'Suspended',
                4: 'Disabled'
            };

            function statusBadge(s) {
                if (s == 1) return '<span class="badge bg-success">Active</span>';
                if (s == 2) return '<span class="badge bg-secondary">InActive</span>';
                if (s == 3) return '<span class="badge bg-warning text-dark">Suspended</span>';
                return '<span class="badge bg-danger">Disabled</span>';
            }


            function loadTable() {
                var account = $('#srch-account').val().trim();
                var userid = $('#srch-userid').val().trim();
                var code = $('#srch-code').val().trim();
                var name = $('#srch-name').val().trim();

                if (!account && !userid && !code && !name) {
                    Swal.fire('Warning', 'Please enter at least one search criteria.', 'warning');
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.surrender.search') }}',
                    method: 'GET',
                    data: {
                        account,
                        userid,
                        code,
                        name
                    },
                    beforeSend: function() {
                        $('#global-loader').fadeIn();
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message, 'error');
                            return;
                        }
                        if (res.data.length === 0) {
                            Swal.fire('Not Found', 'No customers found for the given criteria.',
                                'warning');
                            $('#result-card').addClass('d-none');
                            return;
                        }
                        var html = '';
                        $.each(res.data, function(i, c) {
                            html += `<tr>
                        <td>${i + 1}</td>
                        <td>${c.Cust_Code ?? '-'}</td>
                        <td>${c.Cust_Name}</td>
                        <td>${c.User_Id}</td>
                        <td>${c.Account_No ?? '-'}</td>
                        <td>${c.Contact_No ?? '-'}</td>
                        <td>${c.Counter_Name ?? '-'}</td>
                        <td>${c.Package_Name ?? '-'}</td>
                        <td>${statusBadge(c.Status)}</td>
                        <td>
                            <button class="btn btn-sm btn-cyan btn-edit"
                                data-id="${c.Cust_Id}"
                                data-code="${c.Cust_Code}"
                                data-name="${c.Cust_Name}"
                                data-userid="${c.User_Id}"
                                data-account="${c.Account_No}"
                                data-status="${c.Status}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>`;
                        });
                        $('#surrender-tbody').html(html);
                        $('#result-card').removeClass('d-none');
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    },
                    complete: function() {
                        $('#global-loader').fadeOut('slow');
                    }
                });
            }

            $('#btn-search').on('click', loadTable);

            $('#btn-reset').on('click', function() {
                if ($.fn.DataTable.isDataTable('#surrender-table')) {
                    $('#surrender-table').DataTable().destroy();
                }
                $('#srch-account, #srch-userid, #srch-code, #srch-name').val('');
                $('#result-card').addClass('d-none');
                $('#surrender-tbody').html('');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#s-cust-id').val(el.data('id'));
                $('#s-show-code').text(el.data('code'));
                $('#s-show-name').text(el.data('name'));
                $('#s-show-userid').text(el.data('userid'));
                $('#s-show-account').text(el.data('account'));
                $('#s-show-status').text(statusLabels[el.data('status')] || 'N/A');
                $('#s-status').val('');
                $('#surrenderModal').modal('show');
            });

            $('#btn-surrender-update').on('click', function() {
                if (!$('#s-status').val()) {
                    Swal.fire('Validation', 'Please select a status.', 'warning');
                    return;
                }
                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Updating...');
                $.ajax({
                    url: '{{ route('admin.surrender.save') }}',
                    method: 'POST',
                    data: $('#surrenderForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#surrenderModal').modal('hide');
                            Swal.fire('Success!', res.message, 'success').then(() =>
                                loadTable());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.',
                            'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-save me-1"></i> Update');
                    }
                });
            });

        });
    </script>
@endpush
