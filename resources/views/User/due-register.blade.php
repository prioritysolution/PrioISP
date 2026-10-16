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

            <div class="page-title-banner shadow-sm">Due Register</div>

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
                        @isset($counters)
                            <div class="col-md-3">
                                <label class="filter-label">Counter</label>
                                <select id="ddl-counter" class="form-select">
                                    <option value="">All Counters</option>
                                    @foreach ($counters as $c)
                                        <option value="{{ $c->Id }}">{{ $c->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
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
                        <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-list me-2"
                                style="color:#00c4cc;"></i> DUE REGISTER</h6>
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
                                    <th>Demand Date</th>
                                    <th>Demnad Amount</th>
                                    <th>Invoice No.</th>
                                    <th>Renewal Details</th>

                                    <th>GST</th>
                                    <th>Due Amount</th>
                                    <th>Demand Date</th>
                                </tr>
                            </thead>
                            <tbody id="report-tbody"></tbody>
                            <tfoot>
                                <tr class="table-header text-uppercase fw-bold">
                                    <td colspan="4" class="text-end">Total</td>
                                    <td id="foot-demand">₹ 0.00</td>
                                    <td colspan="2"></td>
                                    <td id="foot-gst">₹ 0.00</td>
                                    <td id="foot-due">₹ 0.00</td>
                                    <td></td>
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
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            var d = new Date(dateStr);
            var m = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return d.getDate().toString().padStart(2, '0') + '-' + m[d.getMonth()] + '-' + d.getFullYear();
        }

        function fmtAmt(val) {
            return val ? '₹ ' + parseFloat(val).toFixed(2) : '-';
        }

        function counterLabel() {
            var $c = $('#ddl-counter');
            if (!$c.length || !$c.val()) return '';
            return ' | Counter: ' + $c.find('option:selected').text();
        }

        $('#btn-search').on('click', function() {
            var fromDate = $('#txt-from-date').val();
            var toDate = $('#txt-to-date').val();
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
                url: '{{ route($dataRoute) }}',
                method: 'GET',
                data: {
                    from_date: fromDate,
                    to_date: toDate,
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
                    $('#report-meta-info').text('Period: ' + formatDate(fromDate) + ' to ' + formatDate(
                        toDate) + counterLabel());
                    var html = res.data.length === 0 ?
                        '<tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>' :
                        '';
                    var totalDemand = 0,
                        totalGst = 0,
                        totalDue = 0;

                    $.each(res.data, function(i, r) {
                        totalDemand += parseFloat(r.Plan_Amount) || 0;
                        totalGst += parseFloat(r.GST_Amt) || 0;
                        totalDue += parseFloat(r.Due_Amt) || 0;

                        html += `<tr>
                          <td>${r.Sl_No}</td>
                          <td class="fw-bold">${r.Cust_Name}</td>
                          <td>${r.User_Id}</td>
                          <td>${r.Demand_Date}</td>
                          <td>${fmtAmt(r.Plan_Amount)}</td>
                          <td>${r.Inv_No ?? '-'}</td>
                          <td>${r.Renewal_Details}</td>
                          <td>${fmtAmt(r.GST_Amt)}</td>
                          <td class="text-danger fw-bold">₹ ${parseFloat(r.Due_Amt).toFixed(2)}</td>
                          <td>${formatDate(r.Demand_Date)}</td>
                     </tr>`;
                    });

                    $('#foot-demand').text('₹ ' + totalDemand.toFixed(2));
                    $('#foot-gst').text('₹ ' + totalGst.toFixed(2));
                    $('#foot-due').text('₹ ' + totalDue.toFixed(2));

                    $('#report-tbody').html(html);
                    $('#report-card').removeClass('d-none');
                    $('#btn-print').removeClass('d-none');
                    $('#btn-excel').removeClass('d-none');
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
            $('#txt-from-date, #txt-to-date, #ddl-counter').val('');
            $('#report-card').addClass('d-none');
            $('#btn-print').addClass('d-none');
            $('#btn-excel').addClass('d-none');
        });

        $('#btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`<html><head><title>Due Register</title>
        <style>
            body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
            h5{text-align:center;margin-bottom:5px;font-size:15px;font-weight:800;text-transform:uppercase;}
            .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
            table{width:100%;border-collapse:collapse;}
            th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
            th{background:#f8f9fa;font-weight:700;text-transform:uppercase;}
            .due{color:#dc3545;font-weight:700;}
        </style></head><body>
        <h5>Due Register</h5>
        <div class="meta">${$('#report-meta-info').text()} | Total: ${$('#lbl-total').text()} records</div>
        ${$('#report-table').prop('outerHTML')
            .replace(/text-danger fw-bold/g,'due')}
        </body></html>`);
            w.document.close();
            w.print();
        });
        $('#btn-excel').on('click', function () {
    var rows = [['Sl#','Customer Name','User ID','Demand Date','Demand Amount','Invoice No','Renewal Details','GST','Due Amount','Demand Date']];
    $('#report-tbody tr').each(function () {
        var cols = [];
        $(this).find('td').each(function () { cols.push($(this).text().trim()); });
        if (cols.length > 0) rows.push(cols);
    });
    rows.push(['','','','Total:', $('#foot-demand').text(),'','', $('#foot-gst').text(), $('#foot-due').text(),'']);
    var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g,'""') + '"').join(',')).join('\n');
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], {type:'text/csv;charset=utf-8;'}));
    a.download = 'Due_Register_' + $('#txt-from-date').val() + '_to_' + $('#txt-to-date').val() + '.csv';
    a.click();
});

    </script>
@endpush
