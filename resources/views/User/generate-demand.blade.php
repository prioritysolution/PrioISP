@extends('Dashboard.Layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <style>
                .filter-label {
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #495057;
                    text-transform: uppercase;
                    margin-bottom: 6px;
                    display: block;
                }

                .dataTables_length {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    padding-top: 0 !important;
                    margin-top: 0 !important;
                }

                .dataTables_length label {
                    margin-bottom: 0;
                    line-height: 1;
                }
            </style>


            <div class="page-title-banner shadow-sm"
                style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
                Generate Renewal
            </div>

            {{-- Search --}}
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
                        <div class="col-md-2">
                            <label class="filter-label">Name</label>
                            <input type="text" id="srch-name" class="form-control" placeholder="Customer Name...">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-cyan w-100" id="btn-search"><i class="fas fa-search me-1"></i>
                                Show</button>
                            <button class="btn btn-secondary w-100" id="btn-reset"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer Info + Payment History --}}
            <div class="d-none" id="result-section">

                {{-- Customer Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <input type="hidden" id="cust-id">
                            <div class="col-md-3">
                                <label class="filter-label">Customer Name</label>
                                <div class="fw-bold" id="show-name"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="filter-label">Account No</label>
                                <div class="fw-bold" id="show-account"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="filter-label">User ID</label>
                                <div class="fw-bold" id="show-userid"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="filter-label">Package</label>
                                <div class="fw-bold" id="show-package"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="filter-label">Renew Upto</label>
                                <div class="fw-bold text-danger" id="show-upto"></div>
                            </div>
                            <div class="col-md-1">
                                <label class="filter-label">Due</label>
                                <div class="fw-bold text-danger" id="show-due"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment History full width --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0" style="color:#1a2942;">Payment History</h6>
                        <button class="btn btn-primary" id="btn-open-demand">
                            <i class="fas fa-bolt me-1"></i> Create Renewal
                        </button>

                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="history-table">
                                <thead>
                                    <tr class="table-header text-uppercase"
                                        style="font-size:0.8rem;font-weight:700;background:#f8f9fa;">
                                        <th>#</th>
                                        <th>Inv No</th>
                                        <th>Demand Date</th>
                                        <th>Period</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Receipt No</th>
                                    </tr>
                                </thead>
                                <tbody id="history-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Generate Renewal Modal --}}
    <div class="modal fade" id="demandModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white"><i class="fas fa-bolt me-2"></i> Generate Renewal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">

                    {{-- Current Package Info --}}
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body p-3">
                            <div class="row g-2 text-center">
                                <div class="col-6 col-md-3">
                                    <div style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                        Package</div>
                                    <div class="fw-bold" id="m-cur-package">-</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                        Plan Days</div>
                                    <div class="fw-bold" id="m-cur-days">-</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                        Basic Amt</div>
                                    <div class="fw-bold" id="m-cur-basic">-</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                        Total Amt</div>
                                    <div class="fw-bold text-success" id="m-cur-total">-</div>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <span
                                    style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">Expiry:
                                </span>
                                <span class="fw-bold text-danger" id="m-cur-expiry">-</span>
                            </div>
                        </div>
                    </div>

                    <form id="demand-form">
                        <input type="hidden" id="f-cust-id" name="Cust_Id">

                        <div class="mb-3">
                            <label class="filter-label">Change Package <small
                                    class="text-muted">(optional)</small></label>
                            <select id="f-package" name="Package_Id" class="form-select">
                                <option value="">-- Keep Current Package --</option>
                                @foreach ($packages as $pkg)
                                    <option value="{{ $pkg->Id }}" data-days="{{ $pkg->Plan_Days }}"
                                        data-basic="{{ $pkg->Basic_Amt }}" data-total="{{ $pkg->Total_Amt }}"
                                        data-name="{{ $pkg->Name }}">
                                        {{ $pkg->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- New package details shown when package changed --}}
                        <div id="new-pkg-info" class="card bg-light border-0 mb-3 d-none">
                            <div class="card-body p-3">
                                <div class="row g-2 text-center">
                                    <div class="col-4">
                                        <div
                                            style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                            Plan Days</div>
                                        <div class="fw-bold" id="m-new-days">-</div>
                                    </div>
                                    <div class="col-4">
                                        <div
                                            style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                            Basic Amt</div>
                                        <div class="fw-bold" id="m-new-basic">-</div>
                                    </div>
                                    <div class="col-4">
                                        <div
                                            style="font-size:0.7rem;font-weight:700;color:#6c757d;text-transform:uppercase;">
                                            Total Amt</div>
                                        <div class="fw-bold text-success" id="m-new-total">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="filter-label">Renew From <span class="text-danger">*</span></label>
                            <input type="date" name="Renew_From" id="f-renew-from" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="filter-label">Renew Upto</label>
                            <input type="date" name="Renew_Upto" id="f-renew-upto" class="form-control" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-cyan" id="btn-generate">
                        <i class="fas fa-bolt me-1"></i> Generate Renewal
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            function search() {
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
                        account,
                        userid,
                        code,
                        name
                    },
                    beforeSend: () => $('#global-loader').fadeIn(),
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Not Found', res.message, 'warning');
                            $('#result-section').addClass('d-none');
                            return;
                        }

                        var c = res.customer;
                        $('#cust-id').val(c.Cust_Id).data('plandays', c.Plan_Days).data('basic', c
                            .Total_Amt);
                        $('#f-cust-id').val(c.Cust_Id);
                        $('#show-name').text(c.Cust_Name);
                        $('#show-account').text(c.Account_No);
                        $('#show-userid').text(c.User_Id);
                        $('#show-package').text(c.Package_Name + ' (₹' + c.Total_Amt + ')');
                       $('#show-upto').text(c.Renew_Upto ? c.Renew_Upto : '-');
                        $('#show-due').text('₹ ' + parseFloat(c.Due_Amount).toFixed(2));

                        // store customer data for modal
                        $('#cust-id')
                            .data('pkg-name', c.Package_Name)
                            .data('pkg-days', c.Plan_Days)
                            .data('pkg-basic', c.Basic_Amt)
                            .data('pkg-total', c.Total_Amt)
                            .data('plandays',   c.Plan_Days) 
                            .data('renew-upto', c.Renew_Upto);

                        // payment history
                        var html = '';
                        if (res.renewals.length === 0) {
                            html =
                                '<tr><td colspan="7" class="text-center text-muted py-3">No payment history.</td></tr>';
                        } else {
                            $.each(res.renewals, function(i, r) {
                                var badge = r.Pay_Status == 2 ?
                                    '<span class="badge bg-success">Paid</span>' :
                                    '<span class="badge bg-danger">Unpaid</span>';
                                html += `<tr>
                                    <td>${i + 1}</td>
                                    <td>${r.Inv_No ?? '-'}</td>
                                    <td>${r.Demand_Date ?? '-'}</td>
                                    <td>${r.Renew_From} - ${r.Renew_Upto}</td>
                                    <td>₹ ${parseFloat(r.Total_Amount).toFixed(2)}</td>
                                    <td>${badge}</td>
                                    <td>${r.Receipt_No ?? '-'}</td>
                                </tr>`;
                            });
                        }
                        $('#history-tbody').html(html);
                        $('#result-section').removeClass('d-none');

                        if ($.fn.DataTable.isDataTable('#history-table')) {
                            $('#history-table').DataTable().destroy();
                        }
                        if (res.renewals.length > 0) {
                        $('#history-table').DataTable({
                            pageLength: 10,
                            columnDefs: [{
                                orderable: false,
                                targets: [5]
                            }]
                        });
                    }

                    },
                    error: () => Swal.fire('Error', 'Something went wrong.', 'error'),
                    complete: () => $('#global-loader').fadeOut('slow')
                });
            }

            $('#btn-search').on('click', search);

            $('#btn-reset').on('click', function() {
                if ($.fn.DataTable.isDataTable('#history-table')) {
                    $('#history-table').DataTable().destroy();
                }
                $('#srch-account,#srch-userid,#srch-code,#srch-name').val('');
                $('#result-section').addClass('d-none');
            });

            // open modal and populate current package info
            $('#btn-open-demand').on('click', function() {
                var custData = $('#cust-id');

                $('#m-cur-package').text(custData.data('pkg-name') ?? '-');
                $('#m-cur-days').text(custData.data('pkg-days') ?? '-');
                $('#m-cur-basic').text('₹ ' + parseFloat(custData.data('pkg-basic') || 0).toFixed(2));
                $('#m-cur-total').text('₹ ' + parseFloat(custData.data('pkg-total') || 0).toFixed(2));
                $('#m-cur-expiry').text(custData.data('renew-upto') ?? '-');

                // reset form
                $('#f-package').val('');
                $('#new-pkg-info').addClass('d-none');

                // auto-fill renew from
                var renewUpto = custData.data('renew-upto');
                if (renewUpto) {
                    var nextDay = new Date(renewUpto);
                    nextDay.setDate(nextDay.getDate() + 1);
                    var from = nextDay.toISOString().split('T')[0];
                    var days = parseInt(custData.data('pkg-days'));
                    var upto = new Date(nextDay);
                    upto.setDate(upto.getDate() + days - 1);
                    $('#f-renew-from').val(from);
                    $('#f-renew-upto').val(upto.toISOString().split('T')[0]);
                } else {
                    $('#f-renew-from').val('');
                    $('#f-renew-upto').val('');
                }

                $('#demandModal').modal('show');
            });

            // package change in modal
            $('#f-package').on('change', function() {
                var sel = $(this).find('option:selected');
                if ($(this).val()) {
                    var days = parseInt(sel.data('days'));
                    var basic = parseFloat(sel.data('basic'));
                    var total = parseFloat(sel.data('total'));
                    $('#m-new-days').text(days);
                    $('#m-new-basic').text('₹ ' + basic.toFixed(2));
                    $('#m-new-total').text('₹ ' + total.toFixed(2));
                    $('#new-pkg-info').removeClass('d-none');
                    $('#cust-id').data('plandays', days);
                } else {
                    $('#new-pkg-info').addClass('d-none');
                    $('#cust-id').data('plandays', $('#cust-id').data('pkg-days'));
                }

                // recalculate upto
                var from = $('#f-renew-from').val();
                var days = parseInt($('#cust-id').data('plandays'));
                if (from && days) {
                    var upto = new Date(from);
                    upto.setDate(upto.getDate() + days - 1);
                    $('#f-renew-upto').val(upto.toISOString().split('T')[0]);
                }
            });

            $('#f-renew-from').on('change', function() {
                var from = $(this).val();
                var days = parseInt($('#cust-id').data('plandays'));
                if (!from || !days) return;
                var upto = new Date(from);
                upto.setDate(upto.getDate() + days - 1);
                $('#f-renew-upto').val(upto.toISOString().split('T')[0]);
            });

            $('#btn-generate').on('click', function() {
                var from = $('#f-renew-from').val();
                var upto = $('#f-renew-upto').val();

                if (!from || !upto) {
                    Swal.fire('Validation', 'Please enter Renew From date.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Confirm',
                    text: 'Generate renewal for ' + from + ' to ' + upto + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00c4cc',
                    confirmButtonText: 'Yes, Generate Renewal'
                }).then(function(result) {
                    if (!result.isConfirmed) return;

                    var btn = $('#btn-generate').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin me-1"></i> Generating...');

                    $.ajax({
                        url: '{{ route($storeRoute) }}',
                        method: 'POST',
                        data: $('#demand-form').serialize() + '&_token={{ csrf_token() }}',
                        success: function(res) {
                            if (res.success) {
                                $('#demandModal').modal('hide');
                                Swal.fire({
                                    title: 'Renewal Generated!',
                                    text: res.message +
                                        '\n\nDo you want to make payment now?',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonColor: '#00c4cc',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Yes, Make Payment',
                                    cancelButtonText: 'No, Later'
                                }).then(function(result) {
                                    if (result.isConfirmed) {
                                         document.cookie = 'demand_account=' + encodeURIComponent($('#show-account').text().trim()) + '; path=/; max-age=60';
                                        window.location.href =
                                            '{{ $isAdmin ? route('admin.demand.collection') : route('demand.collection') }}';
                                    } else {
                                        search();
                                    }
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message ??
                                'Something went wrong.', 'error');
                        },
                        complete: () => btn.prop('disabled', false).html(
                            '<i class="fas fa-bolt me-1"></i> Generate Renewal')
                    });
                });
            });

        });
    </script>
@endpush
