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
                    font-size: .75rem;
                    font-weight: 700;
                    color: #495057;
                    text-transform: uppercase;
                    margin-bottom: 6px;
                    display: block;
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
                    padding: 10px 14px;
                    border-bottom: 1px solid #f1f1f1;
                    font-size: .85rem;
                }

                .table-header {
                    font-size: .78rem;
                    font-weight: 700;
                    color: #495057;
                    background-color: #f8f9fa !important;
                }

                .report-meta {
                    font-size: .8rem;
                    color: #6c757d;
                    font-weight: 600;
                }

                .nav-tabs .nav-link.active {
                    color: #1a2942;
                    font-weight: 700;
                    border-bottom: 2px solid #00c4cc;
                }

                .nav-tabs .nav-link {
                    color: #6c757d;
                }
            </style>

            <div class="page-title-banner shadow-sm">Commission Register</div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="commTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-summary" data-bs-toggle="tab" href="#pane-summary">
                        <i class="fas fa-list-alt me-1"></i> Summary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-detail" data-bs-toggle="tab" href="#pane-detail">
                        <i class="fas fa-th-list me-1"></i> Detailed
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                {{-- ===== SUMMARY TAB ===== --}}
                <div class="tab-pane fade show active" id="pane-summary">

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label class="filter-label">From Date <span class="text-danger">*</span></label>
                                    <input type="date" id="s-from" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="filter-label">To Date <span class="text-danger">*</span></label>
                                    <input type="date" id="s-to" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button class="btn btn-cyan w-100" id="s-btn-search"><i class="fas fa-search me-1"></i>
                                        Search</button>
                                    <button class="btn btn-secondary w-100" id="s-btn-reset"><i
                                            class="fas fa-times me-1"></i> Reset</button>
                                    <button class="btn btn-outline-secondary w-100 d-none" id="s-btn-print"><i
                                            class="fas fa-print me-1"></i> Print</button>
                                    <button class="btn btn-outline-success w-100 d-none" id="s-btn-excel"><i
                                            class="fas fa-file-excel me-1"></i> CSV</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm d-none" id="s-result-card">
                        <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-list-alt me-2"
                                        style="color:#00c4cc;"></i> COMMISSION REGISTER — SUMMARY</h6>
                                <div class="report-meta mt-1" id="s-meta">-</div>
                            </div>
                            <div class="report-meta">Total: <span class="fw-bold text-dark" id="s-total">0</span> records
                            </div>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="s-table">
                                    <thead>
                                        <tr class="table-header text-uppercase">
                                            <th>Sl #</th>
                                            <th>Zone Name</th>
                                            <th>Operator Name</th>
                                            <th class="text-end">Coll Amount</th>
                                            <th class="text-end">Comm Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="s-tbody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>{{-- end summary pane --}}

                {{-- ===== DETAILED TAB ===== --}}
                <div class="tab-pane fade" id="pane-detail">

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label class="filter-label">From Date <span class="text-danger">*</span></label>
                                    <input type="date" id="d-from" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="filter-label">To Date <span class="text-danger">*</span></label>
                                    <input type="date" id="d-to" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="filter-label">Zone</label>
                                    <select id="d-zone" class="form-select">
                                        <option value="">— All Zones —</option>
                                        @foreach ($zones ?? [] as $z)
                                            <option value="{{ $z->Id }}">{{ $z->Cd }} — {{ $z->Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button class="btn btn-cyan w-100" id="d-btn-search"><i class="fas fa-search me-1"></i>
                                        Search</button>
                                    <button class="btn btn-secondary w-100" id="d-btn-reset"><i
                                            class="fas fa-times me-1"></i> Reset</button>
                                    <button class="btn btn-outline-secondary w-100 d-none" id="d-btn-print"><i
                                            class="fas fa-print me-1"></i> Print</button>
                                    <button class="btn btn-outline-success w-100 d-none" id="d-btn-excel"><i
                                            class="fas fa-file-excel me-1"></i> CSV</button>
                                </div>




                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm d-none" id="d-result-card">
                        <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-th-list me-2"
                                        style="color:#00c4cc;"></i> COMMISSION REGISTER — DETAILED</h6>
                                <div class="report-meta mt-1" id="d-meta">-</div>
                            </div>
                            <div class="report-meta">Total: <span class="fw-bold text-dark" id="d-total">0</span>
                                records</div>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="d-table">
                                    <thead>
                                        <tr class="table-header text-uppercase">
                                            <th>Sl #</th>
                                            <th>Coll Date</th>
                                            <th>Cust Code</th>
                                            <th>Cust Name</th>
                                            <th>Package</th>
                                            <th class="text-end">Basic Amt</th>
                                            <th class="text-end">Renew Amt</th>
                                            <th class="text-end">Coll Amt</th>
                                            <th class="text-end">Comm Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody id="d-tbody"></tbody>
                                    <tfoot id="d-tfoot" class="d-none">
                                        <tr class="fw-bold" style="background:#f8f9fa;">
                                            <td colspan="5" class="text-end">Total</td>
                                            <td class="text-end" id="d-total-basic">₹ 0.00</td>
                                            <td class="text-end" id="d-total-ren">₹ 0.00</td>
                                            <td class="text-end" id="d-total-coll">₹ 0.00</td>
                                            <td class="text-end" id="d-total-comm">₹ 0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>{{-- end detail pane --}}

            </div>{{-- end tab-content --}}

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function formatDate(d) {
            if (!d) return '-';
            var dt = new Date(d);
            var m = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return dt.getDate().toString().padStart(2, '0') + '-' + m[dt.getMonth()] + '-' + dt.getFullYear();
        }

        function fmtAmt(v) {
            return '₹ ' + (parseFloat(v) || 0).toFixed(2);
        }

        // ===== SUMMARY =====
        $('#s-btn-search').on('click', function() {
            var from = $('#s-from').val(),
                to = $('#s-to').val();
            if (!from || !to) {
                Swal.fire('Warning', 'Please select both dates.', 'warning');
                return;
            }
            if (from > to) {
                Swal.fire('Warning', 'From Date cannot be greater than To Date.', 'warning');
                return;
            }

            var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Loading...');
            $.ajax({
                url: '{{ route('admin.commission.register.summary') }}',
                data: {
                    from_date: from,
                    to_date: to
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    $('#s-tbody').empty();
                    $('#s-result-card, #s-btn-print').addClass('d-none');
                    if (!res.success) {
                        Swal.fire('Error', res.message, 'error');
                        return;
                    }
                    if (!res.data.length) {
                        Swal.fire('No Data', 'No records found.', 'info');
                        return;
                    }

                    $.each(res.data, function(i, r) {
                        $('#s-tbody').append(
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (r.Zone_Name ?? '-') + '</td>' +
                            '<td>' + (r.Operator_Name ?? '-') + '</td>' +
                            '<td class="text-end">' + fmtAmt(r.Coll_Amount) + '</td>' +
                            '<td class="text-end fw-bold text-success">' + fmtAmt(r
                                .Comm_Amount) + '</td>' +
                            '</tr>'
                        );
                    });
                    $('#s-meta').text('Period: ' + formatDate(from) + ' to ' + formatDate(to));
                    $('#s-total').text(res.data.length);
                    $('#s-result-card').removeClass('d-none');
                    $('#s-btn-print').removeClass('d-none');
                    $('#s-btn-excel').removeClass('d-none');

                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-search me-1"></i> Search');
                    $('#global-loader').fadeOut('slow');
                }
            });
        });

        $('#s-btn-reset').on('click', function() {
            $('#s-from, #s-to').val('');
            $('#s-result-card').addClass('d-none');
            $('#s-btn-print').addClass('d-none');
            $('#s-btn-excel').addClass('d-none');

        });

        $('#s-btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`<html><head><title>Commission Register - Summary</title>
    <style>
        body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
        h5{text-align:center;margin-bottom:5px;font-size:15px;font-weight:800;text-transform:uppercase;}
        .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
        table{width:100%;border-collapse:collapse;}
        th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
        th{background:#f8f9fa;font-weight:700;text-transform:uppercase;}
        .text-end{text-align:right;}
        .comm{color:#28a745;font-weight:700;}
    </style></head><body>
    <h5>Commission Register — Summary</h5>
    <div class="meta">${$('#s-meta').text()} | Total: ${$('#s-total').text()} records</div>
    ${$('#s-table').prop('outerHTML').replace(/text-end fw-bold text-success/g,'text-end comm')}
    </body></html>`);
            w.document.close();
            w.print();
        });

        // ===== DETAILED =====
        $('#d-btn-search').on('click', function() {
            var from = $('#d-from').val(),
                to = $('#d-to').val(),
                zone = $('#d-zone').val();
            if (!from || !to) {
                Swal.fire('Warning', 'Please select both dates.', 'warning');
                return;
            }
            if (from > to) {
                Swal.fire('Warning', 'From Date cannot be greater than To Date.', 'warning');
                return;
            }

            var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Loading...');
            $.ajax({
                url: '{{ route('admin.commission.register.detail') }}',
                data: {
                    from_date: from,
                    to_date: to,
                    zone_id: zone
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    $('#d-tbody').empty();
                    $('#d-tfoot').addClass('d-none');
                    $('#d-result-card, #d-btn-print').addClass('d-none');
                    if (!res.success) {
                        Swal.fire('Error', res.message, 'error');
                        return;
                    }
                    if (!res.data.length) {
                        Swal.fire('No Data', 'No records found.', 'info');
                        return;
                    }

                    var totalBasic = 0,
                        totalRen = 0,
                        totalColl = 0,
                        totalComm = 0;
                    $.each(res.data, function(i, r) {
                        totalBasic += parseFloat(r.Basic_Amt) || 0;
                        totalRen += parseFloat(r.Ren_Amt) || 0;
                        totalColl += parseFloat(r.Coll_Amt) || 0;
                        totalComm += parseFloat(r.Comm_Amt) || 0;
                        $('#d-tbody').append(
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + formatDate(r.Coll_Date) + '</td>' +
                            '<td style="color:#00c4cc;">' + (r.Cust_Code ?? '') + '</td>' +
                            '<td class="fw-bold">' + (r.Cust_Name ?? '') + '</td>' +
                            '<td>' + (r.Package ?? '-') + '</td>' +
                            '<td class="text-end">' + fmtAmt(r.Basic_Amt) + '</td>' +
                            '<td class="text-end">' + fmtAmt(r.Ren_Amt) + '</td>' +
                            '<td class="text-end fw-bold text-success">' + fmtAmt(r
                                .Coll_Amt) + '</td>' +
                            '<td class="text-end fw-bold text-primary">' + fmtAmt(r
                                .Comm_Amt) + '</td>' +
                            '</tr>'
                        );
                    });
                    $('#d-total-basic').text(fmtAmt(totalBasic));
                    $('#d-total-ren').text(fmtAmt(totalRen));
                    $('#d-total-coll').text(fmtAmt(totalColl));
                    $('#d-total-comm').text(fmtAmt(totalComm));
                    $('#d-tfoot').removeClass('d-none');

                    var zoneTxt = $('#d-zone option:selected').text().trim();
                    var metaTxt = 'Period: ' + formatDate(from) + ' to ' + formatDate(to);
                    if (zone) metaTxt += ' | Zone: ' + zoneTxt;
                    $('#d-meta').text(metaTxt);
                    $('#d-total').text(res.data.length);
                    $('#d-result-card').removeClass('d-none');
                    $('#d-btn-print').removeClass('d-none');
                    $('#d-btn-excel').removeClass('d-none');
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-search me-1"></i> Search');
                    $('#global-loader').fadeOut('slow');
                }
            });
        });

        $('#d-btn-reset').on('click', function() {
            $('#d-from, #d-to').val('');
            $('#d-zone').val('');
            $('#d-result-card').addClass('d-none');
            $('#d-btn-print').addClass('d-none');
            $('#d-btn-excel').addClass('d-none');
        });

        $('#d-btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`<html><head><title>Commission Register - Detailed</title>
    <style>
        body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
        h5{text-align:center;margin-bottom:5px;font-size:15px;font-weight:800;text-transform:uppercase;}
        .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
        table{width:100%;border-collapse:collapse;}
        th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
        th{background:#f8f9fa;font-weight:700;text-transform:uppercase;}
        tfoot tr{background:#f8f9fa;font-weight:700;}
        .text-end{text-align:right;}
        .coll{color:#28a745;font-weight:700;}
    </style></head><body>
    <h5>Commission Register — Detailed</h5>
    <div class="meta">${$('#d-meta').text()} | Total: ${$('#d-total').text()} records</div>
    ${$('#d-table').prop('outerHTML')
        .replace(/text-end fw-bold text-success/g,'text-end coll')
        .replace(/d-none/g,'')}
    </body></html>`);
            w.document.close();
            w.print();
        });

        $('#s-btn-excel').on('click', function() {
            var rows = [
                ['Sl#', 'Zone Name', 'Operator Name', 'Coll Amount', 'Comm Amount']
            ];
            $('#s-tbody tr').each(function() {
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
            a.download = 'Commission_Register_Zone_Summary_' + $('#s-from').val() + '_to_' + $('#s-to').val() +
                '.csv';
            a.click();
        });

        $('#d-btn-excel').on('click', function() {
            var rows = [
                ['Sl#', 'Coll Date', 'Cust Code', 'Cust Name', 'Package', 'Basic Amt', 'Renew Amt', 'Coll Amt',
                    'Comm Amt'
                ]
            ];
            $('#d-tbody tr').each(function() {
                var cols = [];
                $(this).find('td').each(function() {
                    cols.push($(this).text().trim());
                });
                if (cols.length > 0) rows.push(cols);
            });
            rows.push(['', '', '', '', '', $('#d-total-basic').text(), $('#d-total-ren').text(), $('#d-total-coll')
                .text(), $('#d-total-comm').text()
            ]);
            var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\n');
            var a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], {
                type: 'text/csv;charset=utf-8;'
            }));
            a.download = 'Commission_Register_Zone_Detail_' + $('#d-from').val() + '_to_' + $('#d-to').val() +
                '.csv';
            a.click();
        });
    </script>
@endpush
