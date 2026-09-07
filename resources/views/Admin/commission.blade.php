@extends('Dashboard.Layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <style>
                .filter-label { font-size:.75rem;font-weight:700;color:#495057;text-transform:uppercase;margin-bottom:6px;display:block; }
                .btn-cyan { background-color:#00c4cc;border-color:#00c4cc;color:white;font-weight:500; }
                .btn-cyan:hover { background-color:#00aeb5;color:white; }
                .table th,.table td { vertical-align:middle;padding:10px 14px;border-bottom:1px solid #f1f1f1;font-size:.85rem; }
                .table-header { font-size:.78rem;font-weight:700;color:#495057;background-color:#f8f9fa !important; }
                .report-meta { font-size:.8rem;color:#6c757d;font-weight:600; }
                .page-title-banner { border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px; }
            </style>

            <div class="page-title-banner shadow-sm">Commission Calculation</div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="filter-label">From Date <span class="text-danger">*</span></label>
                            <input type="date" id="from_date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" id="to_date" class="form-control">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-calculate"><i class="fas fa-calculator me-1"></i> Calculate</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times me-1"></i> Reset</button>
                            <button class="btn btn-outline-secondary w-100 d-none" id="btn-print"><i class="fas fa-print me-1"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm d-none" id="result-card">
                <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0" style="color:#1a2942;"><i class="fas fa-percent me-2" style="color:#00c4cc;"></i> COMMISSION CALCULATION</h6>
                        <div class="report-meta mt-1" id="report-meta-info">-</div>
                    </div>
                    <div class="report-meta">Total: <span class="fw-bold text-dark" id="lbl-total">0</span> records</div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="commission-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Zone</th>
                                    <th>Customer ID</th>
                                    <th>Package ID</th>
                                    <th>Period Collection Amt</th>
                                    <th>Comm Amt</th>
                                    <th>Is Paid</th>
                                </tr>
                            </thead>
                            <tbody id="commission-tbody"></tbody>
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

    $('#btn-calculate').on('click', function () {
        var from = $('#from_date').val();
        var to   = $('#to_date').val();
        if (!from || !to) { Swal.fire('Validation', 'Please select both From Date and To Date.', 'warning'); return; }
        if (from > to)    { Swal.fire('Warning', 'From Date cannot be greater than To Date.', 'warning'); return; }

        var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Calculating...');

        $.ajax({
            url: '{{ route('admin.commission.calculate') }}',
            method: 'GET',
            data: { from_date: from, to_date: to },
            beforeSend: function () { $('#global-loader').fadeIn(); },
            success: function (res) {
                $('#commission-tbody').empty();
                $('#result-card').addClass('d-none');
                $('#btn-print').addClass('d-none');

                if (!res.success) { Swal.fire('Error', res.message, 'error'); return; }
                if (res.data.length === 0) { Swal.fire('No Data', 'No commission records found for the selected period.', 'info'); return; }

                $.each(res.data, function (i, row) {
                    $('#commission-tbody').append(
                        '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + (row.From_Date ?? '') + '</td>' +
                        '<td>' + (row.To_Date ?? '') + '</td>' +
                        '<td>' + (row.Zone_Name ?? '-') + '</td>' +
                        '<td>' + (row.Customer_Id ?? '') + '</td>' +
                        '<td>' + (row.Package_Id ?? '') + '</td>' +
                        '<td>₹ ' + parseFloat(row.Period_Collection_Amt).toFixed(2) + '</td>' +
                        '<td>₹ ' + parseFloat(row.Comm_Amt).toFixed(2) + '</td>' +
                        '<td><span class="badge ' + (row.IsPaid === 'Yes' ? 'bg-success' : 'bg-secondary') + '">' + row.IsPaid + '</span></td>' +
                        '</tr>'
                    );
                });

                $('#report-meta-info').text('Period: ' + from + ' to ' + to);
                $('#lbl-total').text(res.data.length);
                $('#result-card').removeClass('d-none');
                $('#btn-print').removeClass('d-none');
            },
            error: function (xhr) { Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.', 'error'); },
            complete: function () {
                btn.prop('disabled', false).html('<i class="fas fa-calculator me-1"></i> Calculate');
                $('#global-loader').fadeOut('slow');
            }
        });
    });

    $('#btn-reset').on('click', function () {
        $('#from_date, #to_date').val('');
        $('#result-card').addClass('d-none');
        $('#btn-print').addClass('d-none');
    });

    $('#btn-print').on('click', function () {
        var w = window.open('', '_blank');
        w.document.write(`<html><head><title>Commission Calculation</title>
        <style>
            body{padding:20px;font-family:Arial,sans-serif;font-size:12px;}
            h5{text-align:center;margin-bottom:5px;font-size:15px;font-weight:800;text-transform:uppercase;}
            .meta{text-align:center;font-size:11px;color:#666;margin-bottom:15px;}
            table{width:100%;border-collapse:collapse;}
            th,td{border:1px solid #ddd;padding:6px 8px;font-size:11px;}
            th{background:#f8f9fa;font-weight:700;text-transform:uppercase;}
            .badge{padding:2px 6px;border-radius:4px;font-size:10px;}
            .bg-success{background:#28a745;color:#fff;}
            .bg-secondary{background:#6c757d;color:#fff;}
        </style></head><body>
        <h5>Commission Calculation</h5>
        <div class="meta">${$('#report-meta-info').text()} | Total: ${$('#lbl-total').text()} records</div>
        ${$('#commission-table').prop('outerHTML')}
        </body></html>`);
        w.document.close();
        w.print();
    });

});
</script>
@endpush
