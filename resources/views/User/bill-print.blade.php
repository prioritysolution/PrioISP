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
            </style>

            <div class="page-title-banner shadow-sm">Last Paid Bill</div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="filter-label">A/C No</label>
                            <input type="text" id="srch-account" class="form-control" placeholder="Account No...">
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">User ID</label>
                            <input type="text" id="srch-userid" class="form-control" placeholder="User ID...">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Cust Code</label>
                            <input type="text" id="srch-code" class="form-control" placeholder="Cust Code...">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-search"><i class="fas fa-search me-1"></i>
                                Search</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times me-1"></i>
                                Reset</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- Receipt Modal (Exact Original Replica) --}}
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

                            body {
                                margin: 0 !important;
                                padding: 0 !important;
                            }

                            .receipt-paper {
                                width: 190mm;
                                max-width: 190mm;
                                margin: 0 auto;
                                font-size: 12px;
                            }

                            @page {
                                size: A4 portrait;
                                margin: 10mm 12mm 10mm 12mm;
                            }
                        }
                    </style>

                    <div class="receipt-paper">
                        <!-- Top Header Section -->
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


                        <!-- Main Outer Box -->
                        <div class="receipt-box">
                            <!-- Received Line -->
                            <div class="row-field">
                                <span class="field-label">Received with thanks from Mr./Mrs./Miss</span>
                                <span class="dotted-line flex-grow-1" id="r-cust-name">&nbsp;</span>
                            </div>

                            <!-- User ID / AC No / Customer ID Line -->
                            <div class="row-field">
                                <span class="field-label" style="width: 70px;">User ID</span>
                                <span class="dotted-line" style="width: 250px;" id="r-user-id">&nbsp;</span>

                                <span class="field-label ms-3" style="width: 60px;">A/C No</span>
                                <span class="dotted-line" style="width: 150px;" id="r-account-no">&nbsp;</span>

                                <span class="field-label ms-3" style="width: 90px;">Customer ID</span>
                                <span class="dotted-line flex-grow-1" id="r-cust-code">&nbsp;</span>
                            </div>

                            <!-- Address Line -->
                            <div class="row-field">
                                <span class="field-label" style="width: 70px;">Address</span>
                                <span class="dotted-line flex-grow-1" id="r-address">&nbsp;</span>
                            </div>

                            <!-- Amount in Words -->
                            <div class="row-field">
                                <span class="field-label" style="width: 130px;">The sum of Rupees</span>
                                <span class="dotted-line flex-grow-1" id="r-amount-words">&nbsp;</span>
                            </div>

                            <!-- Payment Method -->
                            <div class="row-field">
                                <span class="field-label" style="width: 70px;">By</span>
                                <span class="dotted-line flex-grow-1" id="r-pay-mode">&nbsp;</span>
                            </div>
                            <!-- Bank & Cheque Details -->
                            <div class="row-field">
                                <span class="field-label" style="width: 80px;">Bank Name</span>
                                <span class="dotted-line" style="width: 320px;" id="r-bank-name">&nbsp;</span>

                                <span class="field-label ms-4" style="width: 80px;">Cheque No</span>
                                <span class="dotted-line flex-grow-1" id="r-cheque-no">&nbsp;</span>
                            </div>

                            <!-- For / Particulars Line -->
                            <div class="row-field">
                                <span class="field-label" style="width: 40px;">For</span>
                                <span class="dotted-line flex-grow-1" id="r-period" style="line-height: 1.6;">&nbsp;</span>
                            </div>

                            <!-- Bottom Amount Box & Signature -->
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

                        <!-- Footer Note -->
                        <div class="footer-line" id="r-footer">
                            {{ $org->Print_Footer ?? '' }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-print-none justify-content-end">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="printReceipt()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            .receipt-paper {
                width: 190mm;
                padding-top: 5mm;
            }
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



        $('#btn-search').on('click', function() {
            var account = $('#srch-account').val().trim();
            var userid = $('#srch-userid').val().trim();
            var code = $('#srch-code').val().trim();

            if (!account && !userid && !code) {
                Swal.fire('Warning', 'Please enter at least one search criteria.', 'warning');
                return;
            }

            $.ajax({
                url: '{{ route('bill.print.search') }}',
                data: {
                    account,
                    userid,
                    code
                },
                beforeSend: function() {
                    $('#global-loader').fadeIn();
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Not Found', res.message, 'warning');
                        return;
                    }
                    var b = res.bill;
                    $('#r-receipt-no').text(b.receipt_no ?? '-');
                    $('#r-date').text(b.date);
                    $('#r-cust-name').text(b.cust_name);
                    $('#r-cust-code').text(b.cust_code ?? '-');
                    $('#r-address').text(b.address ?? '-');
                    $('#r-account-no').text(b.account_no);
                    $('#r-user-id').text(b.user_id);
                    $('#r-amount').text(b.amount);
                    $('#r-amount-words').text(b.amount_words);
                    $('#r-period').text('Rs. ' + b.amount + '/- against Renew ' + b.package_name +
                        ' package for ' + b.renew_from + ' To ' + b.renew_upto);
                    $('#r-pay-mode').text(b.pay_mode ?? '');
                    $('#receiptModal').modal('show');
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
            $('#srch-account, #srch-userid, #srch-code').val('');
        });
    </script>
@endpush
