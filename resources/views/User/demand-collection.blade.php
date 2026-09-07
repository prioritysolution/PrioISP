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
                    padding: 10px 16px;
                    border-bottom: 1px solid #f1f1f1;
                }

                .table-header {
                    font-size: 0.8rem;
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

                .col-label {
                    font-size: 0.78rem;
                    font-weight: 700;
                    color: #6c757d;
                    text-transform: uppercase;
                }

                .demand-table-wrap {
                    max-height: 220px;
                    overflow-y: auto;
                }
            </style>

            <div class="page-title-banner shadow-sm">Demand Collection</div>

            {{-- Search --}}
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
                            <button class="btn btn-cyan w-100" id="btn-show"><i class="fas fa-search me-1"></i>
                                Show</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Invoice + Collection --}}
            <div class="card border-0 shadow-sm d-none" id="demand-table-card">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-1" style="color:#1a2942;">
                        <i class="fas fa-file-invoice-dollar me-2" style="color:#00c4cc;"></i> DEMAND INVOICES
                        <span class="ms-3" style="color:#00c4cc;">
                            <i class="fas fa-user me-1"></i>
                            <span id="customer-heading-name"></span>
                        </span>
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-4">

                        {{-- Left: Table --}}
                        <div class="col-md-8">
                            <div class="demand-table-wrap">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="table-header text-uppercase">
                                            <th>Sl No</th>
                                            <th>Cust Name</th>
                                            <th>Inv No</th>
                                            <th>Invoice Period</th>
                                            <th>Due Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="demand-tbody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Search a customer to view
                                                demands.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Right: Collection Box --}}
                        <div class="col-md-4">
                            <form id="collection-form">
                                <input type="hidden" id="col-cust-id" name="Cust_Id">
                                <input type="hidden" id="col-renewal-ids" name="Renewal_Ids">
                                <input type="hidden" id="col-net-hidden" name="Net_Amt">

                                <div class="border rounded p-3" style="background:#f8f9fa;">
                                    <h6 class="fw-bold mb-3"
                                        style="color:#1a2942;border-bottom:2px solid #00c4cc;padding-bottom:8px;">
                                        <i class="fas fa-receipt me-2" style="color:#00c4cc;"></i> Collection Details
                                    </h6>
                                    <table class="table table-sm table-borderless mb-3">
                                        <tr>
                                            <td class="col-label" style="width:50%;">Total Due</td>
                                            <td class="fw-bold text-danger" id="col-total">₹ 0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Collection Date</td>
                                            <td><input type="date" name="Receipt_Date" id="col-date"
                                                    class="form-control form-control-sm" value="{{ date('Y-m-d') }}"
                                                    readonly></td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Mode</td>
                                            <td>
                                                <select name="Mode_Id" id="col-mode" class="form-select form-select-sm">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($payModes as $mode)
                                                        <option value="{{ $mode->Id }}">{{ $mode->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Amount (A)</td>
                                            <td><input type="number" name="Coll_Amount" id="col-amount"
                                                    class="form-control form-control-sm" step="0.01" placeholder="0.00"
                                                    readonly></td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Discount (B)</td>
                                            <td><input type="number" name="Discount" id="col-discount"
                                                    class="form-control form-control-sm" step="0.01"
                                                    placeholder="0.00" value="0" oninput="calcNet()"></td>
                                        </tr>
                                        <tr style="border-top:1px solid #dee2e6;">
                                            <td class="col-label">Net Amount (A-B)</td>
                                            <td class="fw-bold text-success" id="col-net">₹ 0.00</td>
                                        </tr>
                                    </table>
                                    <button type="button" class="btn btn-cyan w-100" id="btn-update">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1">
        <div class="modal-dialog" style="max-width: 950px;">
            <div class="modal-content border-0">
                <div class="modal-body p-4 bg-white" id="receipt-content">
                    <style>
                        .receipt-paper {
                            width: 100%;
                            max-width: 820px;
                            margin: auto;
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 13px;
                            color: #000;
                        }

                        .receipt-header {
                            position: relative;
                            text-align: center;
                            margin-bottom: 25px;
                        }

                        .receipt-title {
                            font-size: 18px;
                            font-weight: bold;
                            text-decoration: underline;
                            margin-bottom: 6px;
                        }

                        .org-name {
                            font-size: 14px;
                            font-weight: bold;
                            margin: 0;
                        }

                        .org-address {
                            font-size: 12px;
                            margin-top: 2px;
                        }

                        .header-meta-left {
                            position: absolute;
                            left: 0;
                            top: 35px;
                            font-size: 13px;
                        }

                        .header-meta-right {
                            position: absolute;
                            right: 0;
                            top: 35px;
                            font-size: 13px;
                        }

                        .receipt-box {
                            border: 1.5px solid #000;
                            border-radius: 20px;
                            padding: 18px 22px;
                            position: relative;
                        }

                        .dotted-line {
                            border-bottom: 1px dotted #000;
                            display: inline-block;
                            padding-left: 5px;
                            font-weight: normal;
                        }

                        .row-field {
                            margin-bottom: 10px;
                            display: flex;
                            align-items: baseline;
                        }

                        .field-label {
                            white-space: nowrap;
                        }

                        .amount-box-container {
                            margin-top: 15px;
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-end;
                        }

                        .amount-box {
                            border: 1.5px solid #000;
                            padding: 6px 14px;
                            font-size: 15px;
                            font-weight: bold;
                            display: inline-block;
                        }

                        .signature-box {
                            text-align: right;
                            font-size: 12px;
                        }

                        .footer-line {
                            text-align: center;
                            font-size: 12px;
                            margin-top: 25px;
                            padding-top: 5px;
                            border-top: 1px dotted #000;
                            font-weight: bold;
                        }

                        @media print {
                            .modal-footer {
                                display: none !important;
                            }

                            @page {
                                size: A4 portrait;
                                margin: 10mm 12mm;
                            }
                        }
                    </style>

                    <div class="receipt-paper">
                        <div class="receipt-header">
                            <div class="receipt-title">RECEIPT</div>
                            <div class="org-name">{{ $org->Print_Name ?? $org->Org_Name }}</div>
                            <div class="org-address">{{ $org->Print_Address ?? $org->Org_Address }}</div>
                            <div class="header-meta-left">
                                Receipt No &nbsp;:&nbsp; <span id="r-receipt-no">-</span>
                            </div>
                            <div class="header-meta-right">
                                Date &nbsp;:&nbsp; <span id="r-date">-</span>
                            </div>
                        </div>

                        <div class="receipt-box">
                            <div class="row-field">
                                <span class="field-label">Received with thanks from Mr./Mrs./Miss</span>
                                <span class="dotted-line flex-grow-1" id="r-cust-name">&nbsp;</span>
                            </div>
                            <div class="row-field">
                                <span class="field-label" style="width:70px;">User ID</span>
                                <span class="dotted-line" style="width:250px;" id="r-user-id">&nbsp;</span>
                                <span class="field-label ms-3" style="width:60px;">A/C No</span>
                                <span class="dotted-line" style="width:150px;" id="r-account-no">&nbsp;</span>
                                <span class="field-label ms-3" style="width:90px;">Customer ID</span>
                                <span class="dotted-line flex-grow-1" id="r-cust-code">&nbsp;</span>
                            </div>
                            <div class="row-field">
                                <span class="field-label" style="width:70px;">Address</span>
                                <span class="dotted-line flex-grow-1" id="r-address">&nbsp;</span>
                            </div>
                            <div class="row-field">
                                <span class="field-label" style="width:130px;">The sum of Rupees</span>
                                <span class="dotted-line flex-grow-1" id="r-amount-words">&nbsp;</span>
                            </div>
                            <div class="row-field">
                                <span class="field-label" style="width:70px;">By</span>
                                <span class="dotted-line flex-grow-1" id="r-pay-mode">&nbsp;</span>
                            </div>
                            <div class="row-field">
                                <span class="field-label" style="width:40px;">For</span>
                                <span class="dotted-line flex-grow-1" id="r-period"
                                    style="line-height:1.6;">&nbsp;</span>
                            </div>
                            <div class="amount-box-container">
                                <div class="amount-box">
                                    <span id="r-amount">0.00</span>/-
                                </div>
                                <div class="signature-box">
                                    ( ............................................... )<br>
                                    Channel Partner's Seal with Signature
                                </div>
                            </div>
                        </div>

                        <div class="footer-line">{{ $org->Print_Footer ?? '' }}</div>
                    </div>
                </div>

                <div class="modal-footer d-print-none justify-content-end">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="printReceipt()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var allDemands = []; // store all rows with their serial order

        function calcNet() {
            var a = parseFloat($('#col-amount').val()) || 0;
            var b = parseFloat($('#col-discount').val()) || 0;
            var net = a - b;
            $('#col-net').text('₹ ' + net.toFixed(2));
            $('#col-net-hidden').val(net.toFixed(2));
        }

        function printReceipt() {
            var content = document.getElementById('receipt-content').innerHTML;
            var w = window.open('', '_blank');
            w.document.write(`<!DOCTYPE html>
    <html>
    <head>
        <title>Receipt</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            @page {
                size: A4 portrait;
                margin: 10mm 12mm;
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #000;
                width: 190mm;
                margin: 0 auto;
            }
            .receipt-paper { width: 190mm; padding-top: 5mm; }
            .receipt-header { position: relative; text-align: center; margin-bottom: 20mm; }
            .receipt-title { font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
            .org-name { font-size: 13px; font-weight: bold; }
            .org-address { font-size: 11px; margin-top: 2px; }
            .header-meta-left { position: absolute; left: 0; top: 35px; font-size: 12px; }
            .header-meta-right { position: absolute; right: 0; top: 35px; font-size: 12px; }
            .receipt-box { border: 1.5px solid #000; border-radius: 12px; padding: 14px 18px; }
            .dotted-line { border-bottom: 1px dotted #000; display: inline-block; padding-left: 4px; }
            .row-field { margin-bottom: 9px; display: flex; align-items: baseline; }
            .field-label { white-space: nowrap; }
            .amount-box-container { margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end; }
            .amount-box { border: 1.5px solid #000; padding: 5px 12px; font-size: 14px; font-weight: bold; display: inline-block; }
            .signature-box { text-align: right; font-size: 11px; }
            .footer-line { text-align: center; font-size: 11px; margin-top: 15px; padding-top: 5px; border-top: 1px dotted #000; font-weight: bold; }
            .modal-footer, .d-print-none { display: none !important; }
        </style>
    </head>
    <body>${content}</body>
    </html>`);
            w.document.close();
            w.focus();
            setTimeout(function() {
                w.print();
                w.close();
            }, 300);
        }



        function recalcFromChecked() {
            var total = 0;
            var ids = [];
            var maxChecked = -1;

            $('.chk-demand:checked').each(function() {
                var idx = parseInt($(this).data('index'));
                if (idx > maxChecked) maxChecked = idx;
                total += parseFloat($(this).data('amount'));
                ids.push($(this).val());
            });

            // validate: all rows before maxChecked must be checked
            var valid = true;
            $('.chk-demand').each(function() {
                var idx = parseInt($(this).data('index'));
                if (idx < maxChecked && !$(this).is(':checked')) {
                    valid = false;
                    return false;
                }
            });

            if (!valid) {
                Swal.fire('Warning', 'Please update the earliest due first before selecting a later one.', 'warning');
                $(this).prop('checked', false);
                return;
            }

            $('#col-total').text('₹ ' + total.toFixed(2));
            $('#col-amount').val(total.toFixed(2));
            $('#col-renewal-ids').val(ids.join(','));
            calcNet();
        }

        $('#btn-show').on('click', function() {
            var account = $('#srch-account').val().trim();
            var userid = $('#srch-userid').val().trim();
            var code = $('#srch-code').val().trim();
            var name = $('#srch-name').val().trim();

            if (!account && !userid && !code && !name) {
                Swal.fire('Warning', 'Please enter at least one search criteria.', 'warning');
                return;
            }

            $.ajax({
                url: '{{ route($searchRoute) }}',
                method: 'GET',
                data: {
                    account: account,
                    userid: userid,
                    code: code,
                    name: name
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Not Found', res.message, 'warning');
                        $('#demand-tbody').html(
                            '<tr><td colspan="5" class="text-center text-muted py-4">No records found.</td></tr>'
                        );
                        return;
                    }

                    allDemands = res.demands;
                    $('#customer-heading-name').text(res.demands[0].Cust_Name);
                    $('#col-cust-id').val(res.demands[0].Cust_Id);

                    var html = '';
                    var totalDue = 0;
                    var ids = [];

                    $.each(res.demands, function(i, d) {
                        if (d.Pay_Status != 2) {
                            totalDue += parseFloat(d.Due_Amt);
                            ids.push(d.Renewal_Id);
                        }


                        var action =
                            `<div class="form-check">
                            <input type="checkbox" class="form-check-input chk-demand"
                                id="chk_${d.Renewal_Id}"
                                value="${d.Renewal_Id}"
                                data-index="${i}"
                                data-amount="${d.Due_Amt}"
                                checked>
                            <label class="form-check-label small text-danger fw-bold" for="chk_${d.Renewal_Id}">
                                Unpaid
                            </label>
                           </div>`;

                        html += `<tr>
                        <td>${i + 1}</td>
                         <td>${d.Cust_Name ?? '-'}</td>  
                        <td>${d.Inv_No ?? '-'}</td>
                        <td>${d.Inv_Period}</td>
                        <td class="${d.Due_Amt > 0 ? 'text-danger fw-bold' : 'text-success fw-bold'}">
                            ₹ ${parseFloat(d.Due_Amt).toFixed(2)}
                        </td>
                        <td>${action}</td>
                    </tr>`;
                    });

                    $('#demand-tbody').html(html);
                    $('#col-total').text('₹ ' + totalDue.toFixed(2));
                    $('#col-amount').val(totalDue.toFixed(2));
                    $('#col-renewal-ids').val(ids.join(','));
                    $('#col-discount').val('0');
                    calcNet();
                    $('#demand-table-card').removeClass('d-none');

                    // disable update button if no unpaid demands
                    if (ids.length === 0) {
                        $('#btn-update').prop('disabled', true)
                            .html('<i class="fas fa-check-circle me-1"></i> All Paid')
                            .removeClass('btn-cyan')
                            .addClass('btn-success');
                    } else {
                        $('#btn-update').prop('disabled', false)
                            .html('<i class="fas fa-save me-1"></i> Update')
                            .removeClass('btn-success')
                            .addClass('btn-cyan');
                    }

                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                },
                complete: function() {
                    $('#global-loader').fadeOut('slow');
                }
            });
        });

        // checkbox change handler
        $(document).on('change', '.chk-demand', function() {
            var changedIdx = parseInt($(this).data('index'));
            var isChecked = $(this).is(':checked');

            // if unchecking, uncheck all after this index too
            if (!isChecked) {
                $('.chk-demand').each(function() {
                    if (parseInt($(this).data('index')) > changedIdx) {
                        $(this).prop('checked', false);
                    }
                });
            }

            // if checking, check all before this index
            if (isChecked) {
                var valid = true;
                $('.chk-demand').each(function() {
                    var idx = parseInt($(this).data('index'));
                    if (idx < changedIdx && !$(this).is(':checked')) {
                        valid = false;
                        return false;
                    }
                });

                if (!valid) {
                    $(this).prop('checked', false);
                    Swal.fire('Warning', 'Please clear the earliest due first before selecting a later one.',
                        'warning');
                    return;
                }
            }

            var total = 0;
            var ids = [];
            $('.chk-demand:checked').each(function() {
                total += parseFloat($(this).data('amount'));
                ids.push($(this).val());
            });

            $('#col-total').text('₹ ' + total.toFixed(2));
            $('#col-amount').val(total.toFixed(2));
            $('#col-renewal-ids').val(ids.join(','));
            calcNet();
        });

        $('#btn-reset').on('click', function() {
            $('#srch-account, #srch-userid, #srch-code, #srch-name').val('');
            $('#demand-table-card').addClass('d-none');
            $('#customer-heading-name').text('');
            $('#demand-tbody').html(
                '<tr><td colspan="6" class="text-center text-muted py-4">Search a customer to view demands.</td></tr>'
            );
        });

        $('#btn-update').on('click', function() {
            var renewalIds = $('#col-renewal-ids').val();
            var mode = $('#col-mode').val();
            var date = $('#col-date').val();

            if (!renewalIds) {
                Swal.fire('Warning', 'No demand selected.', 'warning');
                return;
            }
            if (!mode) {
                Swal.fire('Warning', 'Please select payment mode.', 'warning');
                return;
            }

            var btn = $(this).prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

            $.ajax({
                url: '{{ route($collectRoute) }}',
                method: 'POST',
                data: $('#collection-form').serialize() + '&_token={{ csrf_token() }}',
                success: function(res) {
                    if (res.success) {
                        var r = res.receipt;
                        $('#r-receipt-no').text(r.receipt_no);
                        $('#r-date').text(r.date);
                        $('#r-cust-name').text(r.cust_name);
                        $('#r-cust-code').text(r.cust_code ?? '-');
                        $('#r-address').text(r.address ?? '-');
                        $('#r-account-no').text(r.account_no);
                        $('#r-user-id').text(r.user_id);
                        $('#r-amount').text(r.amount);
                        $('#r-amount-words').text(r.amount_words);
                        $('#r-pay-mode').text(r.pay_mode ?? '');
                        $('#r-period').text(r.period);
                        Swal.fire('Success!', res.message, 'success').then(() => {
                            $('#receiptModal').modal('show');
                        });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },

                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Update');
                }
            });
        });


        $('#receiptModal').on('hidden.bs.modal', function() {
            location.reload();
        });
        $(document).ready(function() {
            var match = document.cookie.match(/demand_account=([^;]+)/);
            if (match) {
                var account = decodeURIComponent(match[1]);
                // clear the cookie immediately
                document.cookie = 'demand_account=; path=/; max-age=0';
                $('#srch-account').val(account);
                $('#btn-show').trigger('click');
            }
        });
    </script>
@endpush
