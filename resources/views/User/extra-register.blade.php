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

            <div class="page-title-banner shadow-sm">Extra Amount</div>

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
                        <div class="col-md-3">
                            <label class="filter-label">Customer</label>
                            <input type="text" id="txt-customer" class="form-control" placeholder="Name, user id, account or code">
                        </div>
                        @isset($counters)
                            <div class="col-md-2">
                                <label class="filter-label">Counter</label>
                                <select id="ddl-counter" class="form-select">
                                    <option value="">All Counters</option>
                                    @foreach ($counters as $c)
                                        <option value="{{ $c->Id }}">{{ $c->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-search"><i class="fas fa-search me-1"></i> Search</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times me-1"></i> Reset</button>
                            <button class="btn btn-outline-secondary w-100 d-none" id="btn-print"><i class="fas fa-print me-1"></i> Print</button>
                            <button class="btn btn-outline-success w-100 d-none" id="btn-excel"><i class="fas fa-file-excel me-1"></i> CSV</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm d-none" id="report-card">
                <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0" style="color:#1a2942;">
                            <i class="fas fa-list me-2" style="color:#00c4cc;"></i> EXTRA AMOUNT BY PACKAGE PERIOD
                        </h6>
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
                                    <th>Customer Name</th>
                                    <th>User ID</th>
                                    <th>Account No</th>
                                    <th>Package</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Collection Date</th>
                                    <th>Extra Amount</th>
                                </tr>
                            </thead>
                            <tbody id="report-tbody"></tbody>
                            <tfoot>
                                <tr class="table-header text-uppercase fw-bold">
                                    <td colspan="8" class="text-end">Total Extra</td>
                                    <td id="foot-extra">₹ 0.00</td>
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
        function fmtAmt(v) {
            return '₹ ' + (parseFloat(v) || 0).toFixed(2);
        }

        $('#btn-search').on('click', function() {
            var fromDate = $('#txt-from-date').val();
            var toDate = $('#txt-to-date').val();
            if (!fromDate || !toDate) {
                Swal.fire('Warning', 'Please select from date and to date.', 'warning');
                return;
            }
            if (fromDate > toDate) {
                Swal.fire('Warning', 'From date cannot be after to date.', 'warning');
                return;
            }

            $.ajax({
                url: '{{ route($dataRoute) }}',
                method: 'GET',
                data: {
                    from_date: fromDate,
                    to_date: toDate,
                    customer: $('#txt-customer').val().trim(),
                    counter_id: $('#ddl-counter').val() || ''
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
                    $('#report-meta-info').text('Collection date: ' + formatDate(fromDate) + ' to ' + formatDate(toDate));
                    var html = res.data.length === 0
                        ? '<tr><td colspan="9" class="text-center text-muted py-4">No extra amount found.</td></tr>'
                        : '';
                    var totalExtra = 0;
                    $.each(res.data, function(i, r) {
                        totalExtra += parseFloat(r.Extra_Amt) || 0;
                        html += `<tr>
                            <td>${r.Sl_No}</td>
                            <td class="fw-bold">${r.Cust_Name}</td>
                            <td>${r.User_Id ?? '-'}</td>
                            <td>${r.Account_No ?? '-'}</td>
                            <td>${r.Package_Name || '-'}</td>
                            <td>${formatDate(r.Renew_From)}</td>
                            <td>${formatDate(r.Renew_Upto)}</td>
                            <td>${r.Receipt_Date ? formatDate(r.Receipt_Date) : '-'}</td>
                            <td class="fw-bold">${fmtAmt(r.Extra_Amt)}</td>
                        </tr>`;
                    });
                    $('#foot-extra').text(fmtAmt(totalExtra));
                    $('#report-tbody').html(html);
                    $('#report-card').removeClass('d-none');
                    $('#btn-print, #btn-excel').removeClass('d-none');
                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                },
                complete: function() {
                    $('#global-loader').fadeOut('slow');
                }
            });
        });

        $('#btn-reset').on('click', function() {
            $('#txt-from-date, #txt-to-date, #txt-customer, #ddl-counter').val('');
            $('#report-card, #btn-print, #btn-excel').addClass('d-none');
        });

        $('#btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`<html><head><title>Extra Amount</title>
                <style>
                    body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
                    h5{text-align:center;margin-bottom:5px;}
                    .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
                    table{width:100%;border-collapse:collapse;}
                    th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
                    th{background:#f8f9fa;}
                </style></head><body>
                <h5>Extra Amount by Package Period</h5>
                <div class="meta">${$('#report-meta-info').text()} | Total: ${$('#lbl-total').text()} records</div>
                ${$('#report-table').prop('outerHTML')}
                </body></html>`);
            w.document.close();
            w.print();
        });

        $('#btn-excel').on('click', function() {
            var rows = [['Sl#', 'Customer Name', 'User ID', 'Account No', 'Package', 'From', 'To', 'Collection Date', 'Extra Amount']];
            $('#report-tbody tr').each(function() {
                var cols = [];
                $(this).find('td').each(function() {
                    cols.push($(this).text().trim());
                });
                if (cols.length > 1) rows.push(cols);
            });
            rows.push(['', '', '', '', '', '', '', 'Total Extra', $('#foot-extra').text()]);
            var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\n');
            var a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' }));
            a.download = 'Extra_Amount_' + $('#txt-from-date').val() + '_to_' + $('#txt-to-date').val() + '.csv';
            a.click();
        });
    </script>
@endpush
