@extends('Dashboard.Layouts.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <style>
            .page-title-banner{border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;}
            .filter-label{font-size:0.75rem;font-weight:700;color:#495057;text-transform:uppercase;margin-bottom:6px;display:block;}
            .btn-cyan{background-color:#00c4cc;border-color:#00c4cc;color:white;font-weight:500;}
            .btn-cyan:hover{background-color:#00aeb5;color:white;}
            .table th,.table td{vertical-align:middle;padding:10px 14px;border-bottom:1px solid #f1f1f1;font-size:0.85rem;}
            .table-header{font-size:0.78rem;font-weight:700;color:#495057;background-color:#f8f9fa !important;}
            .type-btn.active{background-color:#1a2942 !important;color:white !important;border-color:#1a2942 !important;}
            .info-box{background:#f8f9fa;border-radius:8px;padding:16px;}
            .info-label{font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;}
            .info-value{font-size:1.1rem;font-weight:700;color:#1a2942;}
        </style>

        <div class="page-title-banner shadow-sm">Commission Payout</div>

        {{-- Type Toggle --}}
        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-outline-secondary type-btn active" id="btn-type-counter" data-type="1">
                <i class="fas fa-store me-1"></i> Counter
            </button>
            <button class="btn btn-outline-secondary type-btn" id="btn-type-zone" data-type="2">
                <i class="fas fa-map-marker-alt me-1"></i> Zone
            </button>
        </div>

        {{-- Search --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4" id="counter-wrap">
                        <label class="filter-label">Counter <span class="text-danger">*</span></label>
                        <select id="ddl-counter" class="form-select">
                            <option value="">-- Select Counter --</option>
                            @foreach ($counters as $c)
                                <option value="{{ $c->Id }}" data-name="{{ $c->Name }}">{{ $c->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-none" id="zone-wrap">
                        <label class="filter-label">Zone <span class="text-danger">*</span></label>
                        <select id="ddl-zone" class="form-select">
                            <option value="">-- Select Zone --</option>
                            @foreach ($zones as $z)
                                <option value="{{ $z->Id }}" data-name="{{ $z->Name }}">{{ $z->Cd }} — {{ $z->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-cyan w-100" id="btn-load"><i class="fas fa-search me-1"></i> Load</button>
                        <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times me-1"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Commission Summary --}}
        <div class="d-none" id="summary-section">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="info-box text-center">
                        <div class="info-label">Total Commission</div>
                        <div class="info-value" id="lbl-total-comm">₹ 0.00</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box text-center">
                        <div class="info-label">Already Paid</div>
                        <div class="info-value text-success" id="lbl-paid-comm">₹ 0.00</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box text-center">
                        <div class="info-label">Due Commission</div>
                        <div class="info-value text-danger" id="lbl-due-comm">₹ 0.00</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-success" id="btn-pay" disabled>
                    <i class="fas fa-money-bill-wave me-1"></i> Make Payout
                </button>
            </div>

            {{-- Payout History --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-3 pb-2 px-4">
                    <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-history me-2" style="color:#00c4cc;"></i> PAYOUT HISTORY</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>Sl #</th>
                                    <th>Pay Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th class="text-end">Total Comm</th>
                                    <th class="text-end">Paid Amt</th>
                                    <th class="text-end">Due Amt</th>
                                    <th>Mode</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="history-tbody">
                                <tr><td colspan="9" class="text-center text-muted py-4">No payout history.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Payout Modal --}}
<div class="modal fade" id="payoutModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#1a2942;">
                <h5 class="modal-title text-white"><i class="fas fa-money-bill-wave me-2"></i> Make Commission Payout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="payout-form">
                    <input type="hidden" id="f-type" name="type">
                    <input type="hidden" id="f-ref-id" name="ref_id">
                    <input type="hidden" id="f-ref-name" name="ref_name">
                    <input type="hidden" id="f-from-date" name="from_date">
                    <input type="hidden" id="f-to-date" name="to_date">
                    <input type="hidden" id="f-total-comm" name="total_comm">

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="info-box text-center">
                                <div class="info-label">Due Commission</div>
                                <div class="info-value text-danger" id="m-due-comm">₹ 0.00</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box text-center">
                                <div class="info-label">Period</div>
                                <div style="font-size:0.85rem;font-weight:600;" id="m-period">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="filter-label">Pay Date <span class="text-danger">*</span></label>
                        <input type="date" name="pay_date" id="f-pay-date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="filter-label">Payment Mode <span class="text-danger">*</span></label>
                        <select name="pay_mode" id="f-pay-mode" class="form-select">
                            <option value="">-- Select Mode --</option>
                            @foreach ($payModes as $mode)
                                <option value="{{ $mode->Id }}">{{ $mode->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="filter-label">Amount Paying <span class="text-danger">*</span></label>
                        <input type="number" name="paid_amt" id="f-paid-amt" class="form-control" step="0.01" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="filter-label">Remarks</label>
                        <input type="text" name="remarks" id="f-remarks" class="form-control" placeholder="Remarks...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn-confirm-pay">
                    <i class="fas fa-check me-1"></i> Confirm Payout
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var currentType = 1;
var currentRefId = null;
var currentRefName = null;

function formatDate(d) {
    if (!d) return '-';
    var dt = new Date(d);
    var m = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    return dt.getDate().toString().padStart(2,'0') + '-' + m[dt.getMonth()] + '-' + dt.getFullYear();
}
function fmtAmt(v) { return '₹ ' + (parseFloat(v) || 0).toFixed(2); }

$('.type-btn').on('click', function() {
    $('.type-btn').removeClass('active');
    $(this).addClass('active');
    currentType = parseInt($(this).data('type'));
    if (currentType === 1) {
        $('#counter-wrap').removeClass('d-none');
        $('#zone-wrap').addClass('d-none');
    } else {
        $('#counter-wrap').addClass('d-none');
        $('#zone-wrap').removeClass('d-none');
    }
    $('#summary-section').addClass('d-none');
});

$('#btn-load').on('click', function() {
    var sel = currentType === 1 ? $('#ddl-counter') : $('#ddl-zone');
    currentRefId   = sel.val();
    currentRefName = sel.find('option:selected').data('name');

    if (!currentRefId) {
        Swal.fire('Warning', currentType === 1 ? 'Please select a Counter.' : 'Please select a Zone.', 'warning');
        return;
    }

    var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Loading...');

    $.ajax({
        url: '{{ route('admin.commission.payout.due') }}',
        data: { type: currentType, ref_id: currentRefId },
        beforeSend: () => $('#global-loader').fadeIn(),
        success: function(res) {
            if (!res.success) { Swal.fire('Error', res.message, 'error'); return; }

            var d = res.data;
            $('#lbl-total-comm').text(fmtAmt(d.Total_Comm));
            $('#lbl-paid-comm').text(fmtAmt(d.Paid_Comm));
            $('#lbl-due-comm').text(fmtAmt(d.Due_Comm));

            // enable pay button only if due > 0
            if (parseFloat(d.Due_Comm) > 0) {
                $('#btn-pay').prop('disabled', false)
                    .data('from', d.From_Date)
                    .data('to', d.To_Date)
                    .data('due', d.Due_Comm);
            } else {
                $('#btn-pay').prop('disabled', true);
            }

            $('#summary-section').removeClass('d-none');
            loadHistory();
        },
        error: function(xhr) { Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error'); },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fas fa-search me-1"></i> Load');
            $('#global-loader').fadeOut('slow');
        }
    });
});

function loadHistory() {
    $.ajax({
        url: '{{ route('admin.commission.payout.history') }}',
        data: { type: currentType, ref_id: currentRefId },
        success: function(res) {
            if (!res.success || !res.data.length) {
                $('#history-tbody').html('<tr><td colspan="9" class="text-center text-muted py-4">No payout history.</td></tr>');
                return;
            }
            var html = '';
            $.each(res.data, function(i, r) {
                var dueBadge = parseFloat(r.Due_Amt) > 0
                    ? '<span class="badge bg-danger">' + fmtAmt(r.Due_Amt) + '</span>'
                    : '<span class="badge bg-success">Fully Paid</span>';
                html += '<tr>' +
                    '<td>' + (i+1) + '</td>' +
                    '<td>' + formatDate(r.Pay_Date) + '</td>' +
                    '<td>' + formatDate(r.From_Date) + '</td>' +
                    '<td>' + formatDate(r.To_Date) + '</td>' +
                    '<td class="text-end">' + fmtAmt(r.Total_Comm) + '</td>' +
                    '<td class="text-end fw-bold text-success">' + fmtAmt(r.Paid_Amt) + '</td>' +
                    '<td class="text-end">' + dueBadge + '</td>' +
                    '<td>' + (r.Pay_Mode ?? '-') + '</td>' +
                    '<td>' + (r.Remarks ?? '-') + '</td>' +
                    '</tr>';
            });
            $('#history-tbody').html(html);
        }
    });
}

$('#btn-pay').on('click', function() {
    var fromDate = $(this).data('from');
    var toDate   = $(this).data('to');
    var due      = $(this).data('due');

    $('#f-type').val(currentType);
    $('#f-ref-id').val(currentRefId);
    $('#f-ref-name').val(currentRefName);
    $('#f-from-date').val(fromDate);
    $('#f-to-date').val(toDate);
    $('#f-total-comm').val(due);
    $('#m-due-comm').text(fmtAmt(due));
    $('#m-period').text(formatDate(fromDate) + ' to ' + formatDate(toDate));
    $('#f-paid-amt').val(parseFloat(due).toFixed(2));
    $('#f-pay-mode').val('');
    $('#f-remarks').val('');

    $('#payoutModal').modal('show');
});

$('#btn-confirm-pay').on('click', function() {
    var mode    = $('#f-pay-mode').val();
    var amt     = parseFloat($('#f-paid-amt').val()) || 0;
    var due     = parseFloat($('#f-total-comm').val()) || 0;
    var payDate = $('#f-pay-date').val();

    if (!mode)    { Swal.fire('Validation', 'Please select payment mode.', 'warning'); return; }
    if (!payDate) { Swal.fire('Validation', 'Please select pay date.', 'warning'); return; }
    if (amt <= 0) { Swal.fire('Validation', 'Please enter a valid amount.', 'warning'); return; }
    if (amt > due){ Swal.fire('Validation', 'Amount cannot exceed due commission.', 'warning'); return; }

    var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
        url: '{{ route('admin.commission.payout.save') }}',
        method: 'POST',
        data: $('#payout-form').serialize() + '&_token={{ csrf_token() }}',
        success: function(res) {
            if (res.success) {
                $('#payoutModal').modal('hide');
                Swal.fire('Success', res.message, 'success').then(() => $('#btn-load').click());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function(xhr) { Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error'); },
        complete: () => btn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Confirm Payout')
    });
});

$('#btn-reset').on('click', function() {
    $('#ddl-counter, #ddl-zone').val('');
    $('#summary-section').addClass('d-none');
});
</script>
@endpush
