@extends('Dashboard.Layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <style>
                .page-title-banner {
                    border: 1px solid #1a2942;
                    border-radius: 8px;
                    padding: 12px;
                    text-align: center;
                    font-weight: 600;
                    font-size: 1.25rem;
                    color: #1a2942;
                    background: #fff;
                    margin-bottom: 24px;
                }

                .filter-label {
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #495057;
                    text-transform: uppercase;
                    margin-bottom: 6px;
                    display: block;
                }

                .table th,
                .table td {
                    vertical-align: middle;
                    padding: 10px 14px;
                    border-bottom: 1px solid #f1f1f1;
                    font-size: 0.85rem;
                }

                .table-header {
                    font-size: 0.78rem;
                    font-weight: 700;
                    color: #495057;
                    background-color: #f8f9fa !important;
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

                .report-meta {
                    font-size: 0.8rem;
                    color: #6c757d;
                    font-weight: 600;
                }
            </style>

            <div class="page-title-banner shadow-sm">Customer Register Report</div>

            {{-- Filter Panel --}}
            {{-- Filter Panel --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="filter-label">From Date <span class="text-danger">*</span></label>
                            <input type="date" id="txt-from-date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" id="txt-to-date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Status</label>
                            <select id="ddl-status" class="form-select">
                                <option value="">All</option>
                                @foreach ($statusList as $status)
                                    <option value="{{ $status->Id }}">{{ $status->IdVal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Zone</label>
                            <select id="ddl-zone" class="form-select">
                                <option value="">All Zones</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->Id }}">{{ $zone->Cd }} — {{ $zone->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-search"><i class="fas fa-search me-1"></i>
                                Search</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times me-1"></i>
                                Reset</button>
                            <button class="btn btn-outline-secondary w-100 d-none" id="btn-print"><i
                                    class="fas fa-print me-1"></i> Print</button>
                            <button class="btn btn-outline-success w-100 d-none" id="btn-excel"><i
                                    class="fas fa-file-excel me-1"></i> CSV</button>
                        </div>

                    </div>
                </div>
            </div>



            {{-- Report Card --}}
            <div class="card border-0 shadow-sm d-none" id="report-card">
                <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0" style="color:#1a2942;">
                            <i class="fas fa-users me-2" style="color:#00c4cc;"></i> CUSTOMER REGISTER
                        </h6>
                        <div class="report-meta mt-1" id="report-meta-info">-</div>
                    </div>
                    <div class="report-meta">
                        Total: <span class="fw-bold text-dark" id="lbl-total">0</span> customers
                    </div>
                </div>

                <div class="card-body px-4 pb-4">
                    <div class="table-responsive" id="print-area">
                        <table class="table table-hover mb-0" id="register-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>Sl #</th>
                                    <th>Customer Name</th>
                                    <th>Contact No.</th>
                                    <th>User ID</th>
                                    <th>Client ID</th>
                                    <th>IP</th>
                                    <th>Plan Name</th>
                                    <th>Valid Upto</th>
                                    <th>Join Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="register-tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            var d = new Date(dateStr);
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return d.getDate().toString().padStart(2, '0') + '-' + months[d.getMonth()] + '-' + d.getFullYear();
        }

        $('#btn-search').on('click', function() {
            var fromDate = $('#txt-from-date').val();
            var toDate = $('#txt-to-date').val();
            var status = $('#ddl-status').val();
            var zoneId = $('#ddl-zone').val();

            if (!fromDate) {
                Swal.fire('Warning', 'Please select From Date.', 'warning');
                return;
            }
            if (!toDate) {
                Swal.fire('Warning', 'Please select To Date.', 'warning');
                return;
            }
            if (fromDate > toDate) {
                Swal.fire('Warning', 'From Date cannot be greater than To Date.', 'warning');
                return;
            }

            $.ajax({
                url: '{{ route('report.customer.register.data') }}',
                method: 'GET',
                data: {
                    from_date: fromDate,
                    to_date: toDate,
                    status: status,
                    zone_id: zoneId
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message, 'error');
                        return;
                    }

                    $('#lbl-total').text(res.total);
                    $('#report-meta-info').text('Period: ' + formatDate(fromDate) + ' to ' + formatDate(
                        toDate));

                    var html = '';
                    if (res.data.length === 0) {
                        html =
                            '<tr><td colspan="10" class="text-center text-muted py-4">No records found.</td></tr>';
                    } else {
                        $.each(res.data, function(i, r) {
                            var statusBadge = '';
                            if (r.Cust_Status === 'Active') {
                                statusBadge = '<span class="badge bg-success">Active</span>';
                            } else if (r.Cust_Status === 'InActive') {
                                statusBadge =
                                    '<span class="badge bg-secondary">InActive</span>';
                            } else if (r.Cust_Status === 'Suspended') {
                                statusBadge =
                                    '<span class="badge bg-warning text-dark">Suspended</span>';
                            } else {
                                statusBadge = '<span class="badge bg-dark">Unknown</span>';
                            }
                            html += `<tr>
                        <td>${r.Sl_No}</td>
                        <td class="fw-bold">${r.Cust_Name}</td>
                        <td>${r.Contact_No ?? '-'}</td>
                        <td style="color:#00c4cc;">${r.User_Id}</td>
                        <td>${r.Client_Id ?? '-'}</td>
                        <td>${r.IP ?? '-'}</td>
                        <td>${r.Plan_Name}</td>
                        <td>${formatDate(r.Valid_Upto)}</td>
                        <td>${formatDate(r.Join_Date)}</td>
                        <td>${statusBadge}</td>
                    </tr>`;
                        });
                    }
                    $('#register-tbody').html(html);
                    $('#report-card').removeClass('d-none');
                    $('#btn-print').removeClass('d-none');
                    $('#btn-excel').removeClass('d-none');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON?.errors;
                        var firstError = Object.values(errors)[0][0];
                        Swal.fire('Validation Error', firstError, 'error');
                    } else {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                },
                complete: function() {
                    $('#global-loader').fadeOut('slow');
                }
            });
        });

        $('#btn-reset').on('click', function() {
            $('#txt-from-date, #txt-to-date').val('');
            $('#ddl-status, #ddl-zone').val('');
            $('#report-card').addClass('d-none');
            $('#btn-print').addClass('d-none');
        });


        $('#btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`
        <html><head><title>Customer Register</title>
        <style>
            body { padding:20px; font-family:Arial,sans-serif; font-size:12px; }
            h5 { text-align:center; margin-bottom:5px; font-size:15px; }
            .meta { text-align:center; font-size:11px; color:#666; margin-bottom:15px; }
            table { width:100%; border-collapse:collapse; }
            th, td { border:1px solid #ddd; padding:6px 8px; font-size:11px; }
            th { background:#f8f9fa; font-weight:700; text-transform:uppercase; }
            .badge-active    { background:#28a745; color:#fff; padding:2px 6px; border-radius:3px; }
            .badge-suspended { background:#ffc107; color:#000; padding:2px 6px; border-radius:3px; }
            .badge-disabled  { background:#6c757d; color:#fff; padding:2px 6px; border-radius:3px; }
        </style>
        </head><body>
        <h5>Customer Register Report</h5>
        <div class="meta">${$('#report-meta-info').text()} | Total: ${$('#lbl-total').text()} customers</div>
        ${$('#register-table').prop('outerHTML')
            .replace(/badge bg-success/g,           'badge-active')
            .replace(/badge bg-warning text-dark/g, 'badge-suspended')
            .replace(/badge bg-secondary/g,         'badge-disabled')}
        </body></html>
    `);
            w.document.close();
            w.print();
        });

        $('#btn-excel').on('click', function() {
            var rows = [
                ['Sl#', 'Customer Name', 'Contact No', 'User ID', 'Client ID', 'IP', 'Plan Name', 'Valid Upto',
                    'Join Date', 'Status'
                ]
            ];
            $('#register-tbody tr').each(function() {
                var cols = [];
                $(this).find('td').each(function() {
                    cols.push($(this).text().trim());
                });
                if (cols.length > 0) rows.push(cols);
            });
            var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\n');
            var a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], {
                type: 'text/csv;charset=utf-8;'
            }));
            a.download = 'Customer_Register_' + $('#txt-from-date').val() + '_to_' + $('#txt-to-date').val() +
                '.csv';
            a.click();
        });
    </script>
@endpush
