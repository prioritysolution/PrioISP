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
                    font-size: 0.85rem;
                }

                .table-header {
                    font-size: 0.78rem;
                    font-weight: 700;
                    color: #495057;
                    background-color: #f8f9fa !important;
                }

                .report-meta {
                    font-size: 0.8rem;
                    color: #6c757d;
                    font-weight: 600;
                }
            </style>

            <div class="page-title-banner shadow-sm">Commission Register — Counter</div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="filter-label">Counter <span class="text-danger">*</span></label>
                            <select id="ddl-counter" class="form-select">
                                <option value="">-- Select Counter --</option>
                                @foreach ($counters as $c)
                                    <option value="{{ $c->Id }}">{{ $c->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">From Date <span class="text-danger">*</span></label>
                            <input type="date" id="txt-from-date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" id="txt-to-date" class="form-control">
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

            <div class="card border-0 shadow-sm d-none" id="report-card">
                <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-percent me-2"
                                style="color:#00c4cc;"></i> COMMISSION REGISTER — COUNTER</h6>
                        <div class="report-meta mt-1" id="report-meta-info">-</div>
                    </div>
                    <div class="report-meta">Total: <span class="fw-bold text-dark" id="lbl-total">0</span> records</div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="report-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>Sl #</th>
                                    <th>Cust Code</th>
                                    <th>Cust Name</th>
                                    <th>Coll Date</th>
                                    <th class="text-end">Basic Amt</th>
                                    <th class="text-end">Coll Amt</th>
                                    <th class="text-end">Comm Amt</th>
                                </tr>
                            </thead>
                            <tbody id="report-tbody"></tbody>
                            <tfoot id="report-tfoot" class="d-none">
                                <tr class="fw-bold" style="background:#f8f9fa;">
                                    <td colspan="6" class="text-end">Total Commission</td>
                                    <td class="text-end text-success fw-bold" id="lbl-total-comm">₹ 0.00</td>
                                </tr>
                            </tfoot>
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
        function formatDate(d) {
            if (!d) return '-';
            var dt = new Date(d);
            var m = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return dt.getDate().toString().padStart(2, '0') + '-' + m[dt.getMonth()] + '-' + dt.getFullYear();
        }

        function fmtAmt(v) {
            return '₹ ' + (parseFloat(v) || 0).toFixed(2);
        }

        $('#btn-search').on('click', function() {
            var counter = $('#ddl-counter').val();
            var from = $('#txt-from-date').val();
            var to = $('#txt-to-date').val();

            if (!counter) {
                Swal.fire('Warning', 'Please select a Counter.', 'warning');
                return;
            }
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
                url: '{{ route('admin.commission.register.counter.data') }}',
                data: {
                    counter_id: counter,
                    from_date: from,
                    to_date: to
                },
                beforeSend: () => $('#global-loader').fadeIn(),
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message, 'error');
                        return;
                    }
                    if (!res.data.length) {
                        Swal.fire('No Data', 'No records found.', 'info');
                        return;
                    }

                    var totalComm = 0;
                    var html = '';
                    $.each(res.data, function(i, r) {
                        totalComm += parseFloat(r.Comm_Amt) || 0;
                        html += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td style="color:#00c4cc;">' + (r.Cust_Code ?? '') + '</td>' +
                            '<td class="fw-bold">' + (r.Cust_Name ?? '') + '</td>' +
                            '<td>' + formatDate(r.Coll_Date) + '</td>' +
                            '<td class="text-end">' + fmtAmt(r.Basic_Amt) + '</td>' +
                            '<td class="text-end">' + fmtAmt(r.Coll_Amt) + '</td>' +
                            '<td class="text-end fw-bold text-success">' + fmtAmt(r.Comm_Amt) +
                            '</td>' +
                            '</tr>';
                    });
                    $('#report-tbody').html(html);
                    $('#lbl-total-comm').text(fmtAmt(totalComm));
                    $('#lbl-total').text(res.data.length);
                    $('#report-tfoot').removeClass('d-none');
                    $('#report-meta-info').text('Counter: ' + $('#ddl-counter option:selected').text() +
                        ' | Period: ' + formatDate(from) + ' to ' + formatDate(to));
                    $('#report-card').removeClass('d-none');
                    $('#btn-print').removeClass('d-none');
                    $('#btn-excel').removeClass('d-none');

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

        $('#btn-reset').on('click', function() {
            $('#ddl-counter, #txt-from-date, #txt-to-date').val('');
            $('#report-card').addClass('d-none');
            $('#btn-print').addClass('d-none');
            $('#btn-excel').addClass('d-none');
        });

        $('#btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`<html><head><title>Commission Register - Counter</title>
    <style>
        body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
        h5{text-align:center;margin-bottom:5px;font-size:15px;font-weight:800;text-transform:uppercase;}
        .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
        table{width:100%;border-collapse:collapse;}
        th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
        th{background:#f8f9fa;font-weight:700;text-transform:uppercase;}
        tfoot tr{background:#f8f9fa;font-weight:700;}
        .text-end{text-align:right;}.comm{color:#28a745;font-weight:700;}
    </style></head><body>
    <h5>Commission Register — Counter</h5>
    <div class="meta">${$('#report-meta-info').text()} | Total: ${$('#lbl-total').text()} records</div>
    ${$('#report-table').prop('outerHTML').replace(/text-end fw-bold text-success/g,'text-end comm').replace(/d-none/g,'')}
    </body></html>`);
            w.document.close();
            w.print();
        });

        $('#btn-excel').on('click', function () {
    var rows = [['Sl#','Cust Code','Cust Name','Coll Date','Basic Amt','Coll Amt','Comm Amt']];
    $('#report-tbody tr').each(function () {
        var cols = [];
        $(this).find('td').each(function () { cols.push($(this).text().trim()); });
        if (cols.length > 0) rows.push(cols);
    });
    rows.push(['','','','','','Total Commission:', $('#lbl-total-comm').text()]);
    var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g,'""') + '"').join(',')).join('\n');
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], {type:'text/csv;charset=utf-8;'}));
    a.download = 'Commission_Register_Counter_' + $('#txt-from-date').val() + '_to_' + $('#txt-to-date').val() + '.csv';
    a.click();
});

    </script>
@endpush
