@extends('Dashboard.Layouts.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">

        <style>
            .filter-label { font-size: 0.75rem; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 6px; }
            .btn-cyan { background-color: #00c4cc; border-color: #00c4cc; color: white; font-weight: 500; }
            .btn-cyan:hover { background-color: #00aeb5; color: white; }
            .table th, .table td { vertical-align: middle; padding: 10px 16px; border-bottom: 1px solid #f1f1f1; font-size: 0.85rem; }
            .table-header { font-size: 0.8rem; font-weight: 700; color: #495057; background-color: #f8f9fa !important; }
        </style>

        <div class="page-title-banner shadow-sm"
            style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
            Counter Wise Collection
        </div>

        {{-- Filter Panel --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="filter-label">From Date <span class="text-danger">*</span></label>
                        <input type="date" id="txt-from-date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">To Date <span class="text-danger">*</span></label>
                        <input type="date" id="txt-to-date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Counter <span class="text-danger">*</span></label>
                        <select id="ddl-counter" class="form-select">
                            <option value="">-- Select Counter --</option>
                            @foreach($counters as $c)
                            <option value="{{ $c->Id }}">{{ $c->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
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

        {{-- Result Card --}}
        <div class="card border-0 shadow-sm d-none" id="result-card">
            <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0" style="color:#1a2942;">
                    <i class="fas fa-table me-2" style="color:#00c4cc;"></i> Collection Summary
                </h6>
                <span class="fw-bold text-dark" id="lbl-meta"></span>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-header text-uppercase">
                                <th>Sl #</th>
                                <th>Payment Mode</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody id="result-tbody"></tbody>
                        <tfoot>
                            <tr class="fw-bold" style="background:#f8f9fa;">
                                <td colspan="2" class="text-end">Grand Total</td>
                                <td id="lbl-grand-total">₹ 0.00</td>
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
$(document).ready(function () {

    $('#btn-search').on('click', function () {
        var fromDate   = $('#txt-from-date').val();
        var toDate     = $('#txt-to-date').val();
        var counterId  = $('#ddl-counter').val();

        if (!fromDate || !toDate || !counterId) {
            Swal.fire('Warning', 'Please fill all filter fields.', 'warning');
            return;
        }

        $.ajax({
            url: '{{ route('admin.counterwisecollection.data') }}',
            method: 'GET',
            data: { from_date: fromDate, to_date: toDate, counter_id: counterId },
            beforeSend: function() { $('#global-loader').fadeIn(); },
            success: function(res) {
                if (!res.success) {
                    Swal.fire('Error', res.message, 'error');
                    return;
                }

                var html = '';
                var grandTotal = 0;

                $.each(res.data, function(i, r) {
                    grandTotal += parseFloat(r.Total_Amount);
                    html += `<tr>
                        <td>${r.Sl_No}</td>
                        <td>${r.Payment_Mode}</td>
                        <td>₹ ${parseFloat(r.Total_Amount).toFixed(2)}</td>
                    </tr>`;
                });

                if (html === '') {
                    html = '<tr><td colspan="3" class="text-center text-muted py-4">No records found.</td></tr>';
                }

                $('#result-tbody').html(html);
                $('#lbl-grand-total').text('₹ ' + grandTotal.toFixed(2));
                $('#lbl-meta').text($('#ddl-counter option:selected').text() + ' | ' + fromDate + ' to ' + toDate);
                $('#result-card').removeClass('d-none');
            },
            error: function() { Swal.fire('Error', 'Something went wrong.', 'error'); },
            complete: function() { $('#global-loader').fadeOut('slow'); }
        });
    });

    $('#btn-reset').on('click', function () {
        $('#txt-from-date, #txt-to-date').val('');
        $('#ddl-counter').val('');
        $('#result-card').addClass('d-none');
        $('#result-tbody').html('');
    });

});
</script>
@endpush
