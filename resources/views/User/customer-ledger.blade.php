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

                .ledger-header-box {
                    background: #f8f9fa;
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    padding: 16px 20px;
                    margin-bottom: 0;
                }

                .ledger-title {
                    font-size: 1.1rem;
                    font-weight: 800;
                    color: #1a2942;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    border-bottom: 2px solid #00c4cc;
                    padding-bottom: 8px;
                    margin-bottom: 12px;
                }

                .ledger-info-row {
                    font-size: 0.88rem;
                    color: #333;
                    margin-bottom: 4px;
                }

                .ledger-info-row span {
                    font-weight: 700;
                    color: #1a2942;
                }

                .ledger-address-row {
                    font-size: 0.85rem;
                    color: #555;
                    margin-top: 6px;
                }

                .ledger-address-row span {
                    font-weight: 700;
                    color: #1a2942;
                }

                .zone-highlight {
                    display: inline-block;
                    padding: 2px 10px;
                    border-radius: 999px;
                    background: #e8fbfc;
                    border: 1px solid #00c4cc;
                    color: #008890 !important;
                    font-weight: 800 !important;
                    letter-spacing: 0.3px;
                }
            </style>

            <div class="page-title-banner shadow-sm">Customer Ledger</div>

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
                            <label class="filter-label">Phone No</label>
                            <input type="text" id="srch-phone" class="form-control" placeholder="Phone Number...">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-show"><i class="fas fa-search me-1"></i>
                                Show</button>
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

            {{-- Ledger Card --}}
            <div class="card border-0 shadow-sm d-none" id="ledger-card">

                {{-- Printable area starts here --}}
                <div id="print-area">

                    {{-- Customer Header --}}
                    <div class="card-body px-4 pt-4 pb-2">
                        <div class="ledger-header-box">
                            <div class="ledger-title">
                                <i class="fas fa-book me-2" style="color:#00c4cc;"></i> Customer Ledger
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="ledger-info-row">
                                        <span>CUSTOMER NAME:</span> <span id="lbl-name">-</span>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <span>USER ID:</span> <span id="lbl-userid">-</span>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <span>CONTACT NO.:</span> <span id="lbl-contact">-</span>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <span>PLAN NAME:</span> <span id="lbl-plan">-</span>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <span>ZONE:</span> <span id="lbl-zone" class="zone-highlight">-</span>
                                    </div>
                                    <div class="ledger-address-row">
                                        <span>BILLING ADDRESS:</span> <span id="lbl-address">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="ledger-info-row">
                                        <span>PERIOD:</span> <span id="lbl-period">-</span>
                                    </div>
                                    <div class="ledger-info-row">
                                        <span>TOTAL RECORDS:</span> <span id="lbl-count">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ledger Table --}}
                    <div class="card-body px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="ledger-table">
                                <thead>
                                    <tr class="table-header text-uppercase">
                                        <th>Sl #</th>
                                        <th>Demand Dt</th>
                                        <th>Demand Amount</th>
                                        <th>Invoice No</th>
                                        <th>Pay Date</th>
                                        <th>Pay Amount</th>
                                        <th>Disc. Amt</th>
                                        <th>Due Amt</th>
                                        <th>Bill No</th>
                                        <th>Pay Mode</th>
                                        <th>Pay Status</th>
                                        <th>Renew From</th>
                                        <th>Renew Upto</th>
                                    </tr>
                                </thead>
                                <tbody id="ledger-tbody">
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">
                                            Select a customer and date range to view ledger.
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-header text-uppercase">
                                        <td colspan="5" class="text-end fw-bold">Total Paid Amount:</td>
                                        <td class="fw-bold text-success" id="lbl-total-paid">₹ 0.00</td>
                                        <td colspan="7"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                {{-- Printable area ends here --}}

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

        $('#btn-show').on('click', function() {
            var account = $('#srch-account').val().trim();
            var userid = $('#srch-userid').val().trim();
            var code = $('#srch-code').val().trim();
            var name = $('#srch-name').val().trim();
            var phone = $('#srch-phone').val().trim();

            if (!account && !userid && !code && !name && !phone) {
                Swal.fire('Warning', 'Please enter at least one search criteria.', 'warning');
                return;
            }

            $.ajax({
                url: '{{ route($ledgerDataRoute) }}',
                method: 'GET',
                data: {
                    account: account,
                    userid: userid,
                    code: code,
                    name: name,
                    phone: phone
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Not Found', res.message, 'warning');
                        $('#ledger-card').addClass('d-none');
                        return;
                    }

                    var c = res.customer;
                    $('#lbl-name').text(c.Cust_Name);
                    $('#lbl-userid').text(c.User_Id);
                    $('#lbl-contact').text(c.Contact_No);
                    $('#lbl-plan').text(c.Plan_Name);
                    $('#lbl-zone').text(c.Zone_Cd ?? '-');
                    $('#lbl-address').text(c.Billing_Address);
                    $('#lbl-count').text(res.ledger.length);

                    var html = '';
                    var totalPaid = 0;
                    if (res.ledger.length === 0) {
                        html =
                            '<tr><td colspan="13" class="text-center text-muted py-4">No ledger records found.</td></tr>';
                    } else {
                        $.each(res.ledger, function(i, r) {
                            totalPaid += parseFloat(r.Pay_Amount) || 0;
                            var statusBadge = r.Pay_Status === 'Paid' ?
                                '<span class="badge bg-success">Paid</span>' :
                                '<span class="badge bg-danger">Unpaid</span>';

                            html += `<tr>
                            <td>${i + 1}</td>
                            <td>${formatDate(r.Demand_Date)}</td>
                            <td>${r.Total_Amount ? '₹ ' + parseFloat(r.Total_Amount).toFixed(2) : '-'}</td>
                            <td>${r.Inv_No ?? '-'}</td>
                            <td>${r.Pay_Date ? formatDate(r.Pay_Date) : '-'}</td>
                            <td class="fw-bold">${r.Pay_Amount ? '₹ ' + parseFloat(r.Pay_Amount).toFixed(2) : '-'}</td>
                            <td>${r.Disc_Amount ? '₹ ' + parseFloat(r.Disc_Amount).toFixed(2) : '₹ 0.00'}</td>
                            <td class="${parseFloat(r.Due_Amt) > 0 ? 'text-danger fw-bold' : 'text-success fw-bold'}">
                                ₹ ${parseFloat(r.Due_Amt).toFixed(2)}
                            </td>
                            <td>${r.Bill_No ?? '-'}</td>
                            <td>${r.Receipt_Mode ?? '-'}</td>
                            <td>${statusBadge}</td>
                            <td>${formatDate(r.Renew_From)}</td>
                            <td>${formatDate(r.Renew_Upto)}</td>
                        </tr>`;
                        });
                    }

                    $('#ledger-tbody').html(html);
                    $('#lbl-total-paid').text('₹ ' + totalPaid.toFixed(2));
                    $('#ledger-card').removeClass('d-none');
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
            $('#srch-account, #srch-userid, #srch-code, #srch-name,#srch-phone').val('');
            $('#ledger-card').addClass('d-none');
            $('#btn-print').addClass('d-none');
            $('#btn-excel').addClass('d-none');
            $('#lbl-total-paid').text('₹ 0.00');
        });

        $('#btn-print').on('click', function() {
            var w = window.open('', '_blank');
            w.document.write(`
        <html><head><title>Customer Ledger</title>
        <style>
            body { padding:20px; font-family:Arial,sans-serif; font-size:12px; }
            h5 { text-align:center; margin-bottom:5px; font-size:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px; }
            .meta-box { border:1px solid #ddd; border-radius:4px; padding:10px 14px; margin-bottom:15px; background:#f8f9fa; font-size:11px; }
            .meta-box .row1 { margin-bottom:5px; }
            .meta-box b { color:#1a2942; text-transform:uppercase; }
            .zone-badge { display:inline-block; padding:1px 7px; border-radius:999px; background:#e8fbfc; border:1px solid #00c4cc; color:#008890; font-weight:700; }
            .divider { border:none; border-top:1px solid #ddd; margin:6px 0; }
            table { width:100%; border-collapse:collapse; }
            th, td { border:1px solid #ddd; padding:6px 8px; font-size:11px; }
            th { background:#f8f9fa; font-weight:700; text-transform:uppercase; }
            .badge-paid    { background:#28a745; color:#fff; padding:2px 6px; border-radius:3px; font-size:10px; }
            .badge-unpaid  { background:#dc3545; color:#fff; padding:2px 6px; border-radius:3px; font-size:10px; }
            .due           { color:#dc3545; font-weight:700; }
            .paid-amt      { color:#28a745; font-weight:700; }
            .footer { margin-top:15px; font-size:10px; color:#888; text-align:right; }
        </style>
        </head><body>
        <h5>Customer Ledger</h5>
        <div class="meta-box">
            <div class="row1">
                <b>Customer Name:</b> ${$('#lbl-name').text()} &nbsp;|&nbsp;
                <b>User ID:</b> ${$('#lbl-userid').text()} &nbsp;|&nbsp;
                <b>Contact No.:</b> ${$('#lbl-contact').text()} &nbsp;|&nbsp;
                <b>Plan Name:</b> ${$('#lbl-plan').text()} &nbsp;|&nbsp;
                <b>Zone:</b> <span class="zone-badge">${$('#lbl-zone').text()}</span>
            </div>
            <hr class="divider">
            <div class="row1"><b>Billing Address:</b> ${$('#lbl-address').text()}</div>
            <hr class="divider">
            <div><b>Total Records:</b> ${$('#lbl-count').text()} &nbsp;|&nbsp; <b>Printed On:</b> ${new Date().toLocaleDateString('en-IN', {day:'2-digit', month:'short', year:'numeric'})}</div>
        </div>
        ${$('#ledger-table').prop('outerHTML')
            .replace(/badge bg-success/g,      'badge-paid')
            .replace(/badge bg-danger/g,       'badge-unpaid')
            .replace(/text-danger fw-bold/g,   'due')
            .replace(/text-success fw-bold/g,  'paid-amt')}
        <div class="footer">This is a computer generated report.</div>
        </body></html>
    `);
            w.document.close();
            w.print();
        });

        $('#btn-excel').on('click', function() {
            var rows = [];

            rows.push(['Customer Name:', $('#lbl-name').text(), 'User ID:', $('#lbl-userid').text()]);
            rows.push(['Contact No:', $('#lbl-contact').text(), 'Plan Name:', $('#lbl-plan').text(), 'Zone:', $('#lbl-zone').text()]);
            rows.push(['Billing Address:', $('#lbl-address').text()]);
            rows.push(['Total Records:', $('#lbl-count').text()]);
            rows.push([]);

            rows.push(['Sl#', 'Demand Date', 'Demand Amount', 'Invoice No', 'Pay Date', 'Pay Amount', 'Disc Amt', 'Due Amt', 'Bill No', 'Pay Mode', 'Pay Status', 'Renew From', 'Renew Upto']);

            $('#ledger-tbody tr').each(function() {
                var cols = [];
                $(this).find('td').each(function() { cols.push($(this).text().trim()); });
                if (cols.length > 0) rows.push(cols);
            });

            rows.push(['', '', '', '', 'Total Paid:', $('#lbl-total-paid').text(), '', '', '', '', '', '', '']);

            var csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\n');
            var a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob(['\uFEFF' + csv], {type: 'text/csv;charset=utf-8;'}));
            a.download = 'Customer_Ledger_' + $('#lbl-name').text() + '.csv';
            a.click();
        });

    </script>
@endpush
