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
            </style>

            <div class="page-title-banner shadow-sm"
                style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
                Receipt Mode Rectification
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
                        <div class="col-md-2">
                            <label class="filter-label">Receipt Date</label>
                            <input type="date" id="srch-date" class="form-control">
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
                        <table class="table table-hover mb-0" id="rectify-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Cust ID</th>
                                    <th>Demand Date</th>
                                    <th>Renew From</th>
                                    <th>Renew Upto</th>
                                    <th>Total Amt</th>
                                    <th>Receipt No</th>
                                    <th>Receipt Date</th>
                                    <th>Receipt Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rectify-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="rectifyModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exchange-alt me-2"></i> Change Receipt Mode
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light rounded p-3 mb-4">
                        <div class="modal-info-row">
                            <span class="modal-info-label">Customer ID</span>
                            <span class="modal-info-value" id="f-show-cust"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Receipt No</span>
                            <span class="modal-info-value" id="f-show-receipt"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Receipt Date</span>
                            <span class="modal-info-value" id="f-show-date"></span>
                        </div>
                        <div class="modal-info-row">
                            <span class="modal-info-label">Current Mode</span>
                            <span class="modal-info-value text-danger" id="f-show-mode"></span>
                        </div>
                    </div>
                    <form id="rectifyForm">
                        <input type="hidden" id="f-renewal-id" name="Renewal_Id">
                        <input type="hidden" id="f-cust-id" name="Cust_Id">
                        <input type="hidden" id="f-old-mode" name="Old_Mode">
                        <input type="hidden" id="f-new-mode" name="New_Mode">
                        <div>
                            <label class="filter-label">New Mode <span class="text-danger">*</span></label>
                            <select name="New_Mode_Id" id="f-new-mode-id" class="form-select">
                                <option value="">-- Select Mode --</option>
                                @foreach ($modes as $m)
                                    <option value="{{ $m->Mode_Id }}" data-name="{{ $m->Mode }}">
                                        {{ $m->Mode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-cyan" id="btn-update">
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
            if ($.fn.DataTable.isDataTable('#rectify-table')) {
                $('#rectify-table').DataTable().destroy();
            }
            $('#rectify-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [9]
                }]
            });

            function loadTable() {
                var account = $('#srch-account').val().trim();
                var userid = $('#srch-userid').val().trim();
                var code = $('#srch-code').val().trim();
                var name = $('#srch-name').val().trim();
                var receipt_date = $('#srch-date').val();

                if (!account && !userid && !code && !name) {
                    Swal.fire('Warning', 'Please enter at least one search criteria.', 'warning');
                    return;
                }

                $.ajax({
                    url: '{{ route($searchRoute) }}',
                    method: 'GET',
                    data: {
                        account,
                        userid,
                        code,
                        name,
                        receipt_date
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
                            Swal.fire('Not Found', 'No records found for the given criteria.',
                                'warning');
                            $('#result-card').addClass('d-none');
                            return;
                        }
                        var html = '';
                        $.each(res.data, function(i, r) {
                            html += `<tr>
                        <td>${i + 1}</td>
                        <td>${r.Cust_Id}</td>
                        <td>${r.Demand_Date ?? '-'}</td>
                        <td>${r.Renew_From ?? '-'}</td>
                        <td>${r.Renew_Upto ?? '-'}</td>
                        <td>${parseFloat(r.Total_Amount).toFixed(2)}</td>
                        <td>${r.Receipt_No ?? '-'}</td>
                        <td>${r.Receipt_Date ?? '-'}</td>
                        <td>${r.Mode_Name ?? '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-cyan btn-edit"
                                data-renewal="${r.Renewal_Id}"
                                data-cust="${r.Cust_Id}"
                                data-receipt="${r.Receipt_No}"
                                data-date="${r.Receipt_Date}"
                                data-mode="${r.Receipt_Mode}"
                                data-modename="${r.Mode_Name}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>`;
                        });
                        $('#rectify-tbody').html(html);
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
                if ($.fn.DataTable.isDataTable('#rectify-table')) {
                    $('#rectify-table').DataTable().destroy();
                }
                $('#srch-account, #srch-userid, #srch-code, #srch-name,#srch-date').val('');
                $('#result-card').addClass('d-none');
                $('#rectify-tbody').html('');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#f-renewal-id').val(el.data('renewal'));
                $('#f-cust-id').val(el.data('cust'));
                $('#f-old-mode').val(el.data('modename'));
                $('#f-show-cust').text(el.data('cust'));
                $('#f-show-receipt').text(el.data('receipt'));
                $('#f-show-date').text(el.data('date'));
                $('#f-show-mode').text(el.data('modename') || 'N/A');
                $('#f-new-mode-id').val('');
                $('#f-new-mode').val('');
                $('#rectifyModal').modal('show');
            });

            $('#f-new-mode-id').on('change', function() {
                $('#f-new-mode').val($(this).find('option:selected').data('name') || '');
            });

            $('#btn-update').on('click', function() {
                if (!$('#f-new-mode-id').val()) {
                    Swal.fire('Validation', 'Please select a new mode.', 'warning');
                    return;
                }
                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Updating...');
                $.ajax({
                    url: '{{ route($saveRoute) }}',
                    method: 'POST',
                    data: $('#rectifyForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#rectifyModal').modal('hide');
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
