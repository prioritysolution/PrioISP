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
                    background-color: #fff;
                    margin-bottom: 24px;
                }

                .filter-label {
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #495057;
                    text-transform: uppercase;
                    margin-bottom: 6px;
                }

                .summary-card {
                    border: none;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                    border-radius: 8px;
                    height: 100%;
                }

                .summary-card .card-body {
                    padding: 20px;
                }

                .summary-value {
                    font-size: 2rem;
                    font-weight: 700;
                    line-height: 1;
                    margin-bottom: 8px;
                    color: #212529;
                }

                .summary-title {
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #6c757d;
                    text-transform: uppercase;
                }

                .border-cyan {
                    border-left: 4px solid #00c4cc !important;
                }

                .border-green {
                    border-left: 4px solid #28a745 !important;
                }

                .border-orange {
                    border-left: 4px solid #fd7e14 !important;
                }

                .border-grey {
                    border-left: 4px solid #adb5bd !important;
                }

                .icon-cyan {
                    color: #00c4cc;
                }

                .icon-green {
                    color: #28a745;
                }

                .icon-orange {
                    color: #fd7e14;
                }

                .icon-grey {
                    color: #adb5bd;
                }

                .table-header {
                    font-size: 0.8rem;
                    font-weight: 700;
                    color: #495057;
                    background-color: #f8f9fa !important;
                }

                .table th,
                .table td {
                    vertical-align: middle;
                    padding: 12px 16px;
                    border-bottom: 1px solid #f1f1f1;
                }

                .text-cyan {
                    color: #00c4cc;
                }

                .text-danger-custom {
                    color: #dc3545;
                    font-weight: 600;
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

                .btn-toggle-group {
                    transition: all 0.2s;
                }

                .btn-toggle-group.active {
                    background-color: #00c4cc !important;
                    border-color: #00c4cc !important;
                    color: white !important;
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

                .dataTables_wrapper .page-item.active .page-link {
                    background-color: #00c4cc;
                    border-color: #00c4cc;
                    color: white;
                }

                .dataTables_wrapper .page-link {
                    color: #00c4cc;
                }

                .dataTables_wrapper .page-link:hover {
                    color: #00aeb5;
                }

                .table-responsive {
                    overflow: auto !important;
                }
            </style>

            <div class="page-title-banner shadow-sm">Customer Management</div>

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bold mb-1" style="color:#1a2942;">
                        <i class="fas fa-users icon-cyan me-2"></i>Customers
                    </h3>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">Browse, filter and manage all customers across your
                        network.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn bg-white border shadow-sm btn-toggle-group active" id="btn-new-customer">
                        <i class="fas fa-plus me-1"></i> New Customer
                    </button>
                    <button class="btn bg-white border shadow-sm btn-toggle-group" id="btn-filter-toggle">
                        <i class="fas fa-filter me-1"></i> Filters
                    </button>
                    <a href="{{ route('admin.new.customer.export', request()->query()) }}"
                        class="btn bg-white border shadow-sm btn-toggle-group" id="btn-export">
                        <i class="fas fa-download me-1"></i> Export
                    </a>
                </div>

            </div>

            {{-- Filters --}}
            <div class="card border-0 shadow-sm mb-4" id="filter-panel" style="display:none;">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('admin.new.customer') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="filter-label">STATUS</label>
                                <select class="form-select" name="filter_status">
                                    <option value="">All Statuses</option>
                                    @foreach ($statusList as $status)
                                        <option value="{{ $status->Id }}" @selected(request('filter_status') == $status->Id && request('filter_status') !== '')>
                                            {{ $status->IdVal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">CUSTOMER NAME LIKE</label>
                                <input type="text" class="form-control" name="filter_name"
                                    value="{{ request('filter_name') }}" placeholder="Search customer name...">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">WILDCARD SEARCH</label>
                                <input type="text" class="form-control" name="filter_wildcard"
                                    value="{{ request('filter_wildcard') }}" placeholder="ID / Account / Mobile / Code...">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">PAYMENT STATUS</label>
                                <select class="form-select" name="filter_payment">
                                    <option value="">All</option>
                                    <option value="2" {{ request('filter_payment') == '2' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="1" {{ request('filter_payment') == '1' ? 'selected' : '' }}>Unpaid
                                    </option>
                                </select>

                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">PACKAGE</label>
                                <select class="form-select" name="filter_package">
                                    <option value="">All Packages</option>
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg->Id }}"
                                            {{ request('filter_package') == $pkg->Id ? 'selected' : '' }}>
                                            {{ $pkg->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">ZONE</label>
                                <select class="form-select" name="filter_zone">
                                    <option value="">All Zones</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->Id }}"
                                            {{ request('filter_zone') == $zone->Id ? 'selected' : '' }}>
                                            {{ $zone->Cd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">FROM DATE</label>
                                <input type="date" class="form-control" name="filter_from_date"
                                    value="{{ request('filter_from_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">TO DATE</label>
                                <input type="date" class="form-control" name="filter_to_date"
                                    value="{{ request('filter_to_date') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-cyan w-100">
                                    <i class="fas fa-search me-2"></i> FILTER
                                </button>
                                <a href="{{ route('admin.new.customer') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-times me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card summary-card border-cyan bg-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-value">{{ $summary->Total }}</div>
                                <div class="summary-title">TOTAL</div>
                            </div>
                            <i class="fas fa-users fs-3 icon-cyan"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card summary-card border-green bg-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-value">{{ $summary->Active }}</div>
                                <div class="summary-title">ACTIVE</div>
                            </div>
                            <i class="fas fa-check-circle fs-3 icon-green"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card summary-card border-orange bg-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-value">{{ $summary->InActive ?? 0 }}</div>
                                <div class="summary-title">Inactive</div>
                            </div>
                            <i class="fas fa-pause-circle fs-3 icon-orange"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card summary-card border-grey bg-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-value">{{ $summary->Suspended ?? 0 }}</div>
                                <div class="summary-title">Suspended</div>
                            </div>
                            <i class="fas fa-ban fs-3 icon-grey"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-1" style="color:#1a2942;">
                        <i class="fas fa-users icon-cyan me-2"></i> CUSTOMER DIRECTORY
                    </h6>
                    <p class="text-muted text-uppercase" style="font-size:0.7rem; font-weight:700; letter-spacing:0.5px;">
                        Filter accounts, review statuses and manage customers from one place.
                    </p>
                </div>
                <div class="card-body px-4 pb-4">
                    @php
                        $zoneLabels = [];
                        foreach ($zones as $z) {
                            $zoneLabels[$z->Id] = trim($z->Cd . ' — ' . $z->Name);
                        }
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="customer-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th class="border-top-0">Cust Code</th>
                                    <th class="border-top-0">Cust Name</th>
                                    <th class="border-top-0">User ID</th>
                                    <th class="border-top-0">Account No</th>
                                    <th class="border-top-0">Package</th>
                                    <th class="border-top-0">Zone</th>
                                    <th class="border-top-0">Exp Date</th>
                                    <th class="border-top-0">Payment Status</th>
                                    <th class="border-top-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cust)
                                    <tr>
                                        <td>{{ $cust->Cust_Code }}</td>
                                        <td class="fw-bold">{{ $cust->Cust_Name }}</td>
                                        <td class="text-cyan">{{ $cust->User_Id }}</td>
                                        <td>{{ $cust->Account_No }}</td>
                                        <td class="text-muted">{{ $cust->Package }}</td>
                                        <td class="text-muted">{{ $zoneLabels[$cust->Zone_Id] ?? '-' }}</td>
                                        <td class="text-muted">
                                            {{ $cust->Exp_Date ? date('d M Y', strtotime($cust->Exp_Date)) : '-' }}</td>
                                        <td>
                                            @if ($cust->Payment_Status === 'Paid')
                                                <span class="text-success fw-bold">Paid</span>
                                            @elseif ($cust->Payment_Status === 'Unpaid')
                                                <span class="text-danger-custom">Unpaid</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-cyan btn-edit" data-id="{{ $cust->Cust_Id }}"
                                                data-code="{{ $cust->Cust_Code }}" data-name="{{ $cust->Cust_Name }}"
                                                data-join="{{ $cust->Join_Date }}"
                                                data-address="{{ $cust->Billing_Address }}"
                                                data-userid="{{ $cust->User_Id }}"
                                                data-account="{{ $cust->Account_No }}"
                                                data-contact="{{ $cust->Contact_No }}" data-mail="{{ $cust->Mail_Id }}"
                                                data-ip="{{ $cust->IP_Addrs }}" data-package="{{ $cust->Package_Id }}"
                                                data-renewfrom="{{ $cust->Renew_From }}"
                                                data-renewupto="{{ $cust->Exp_Date }}" data-zone="{{ $cust->Zone_Id }}"
                                                data-router="{{ $cust->Router_Dtls }}"
                                                data-remarks="{{ $cust->Remarks }}"
                                                data-payment="{{ $cust->Payment_Status }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete ms-1"
                                                data-id="{{ $cust->Cust_Id }}" data-name="{{ $cust->Cust_Name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                        <div class="text-muted small">
                            Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }}
                            of {{ $customers->total() }} customers
                        </div>
                        <div>
                            {{ $customers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- New/Edit Customer Modal --}}
    <div class="modal fade" id="newCustomerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white" id="modalTitle">
                        <i class="fas fa-user-plus me-2"></i> New Customer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="newCustomerForm">
                        <input type="hidden" name="Cust_Id" id="txt-cust-id">
                        <input type="hidden" id="hidden-package-id" name="Package_Id">

                        <div class="d-flex align-items-center mb-3">
                            <div style="width:4px;height:20px;background:#00c4cc;border-radius:2px;" class="me-2"></div>
                            <h6 class="fw-bold mb-0" style="color:#1a2942;">Customer Information</h6>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="filter-label">Cust Code <span class="text-danger">*</span></label>
                                <input type="text" name="Cust_Code" class="form-control" placeholder="Cust Code">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Cust Name <span class="text-danger">*</span></label>
                                <input type="text" name="Cust_Name" class="form-control" placeholder="Full Name">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Join Date <span class="text-danger">*</span></label>
                                <input type="date" name="Join_Date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Contact No <span class="text-danger">*</span></label>
                                <input type="text" name="Contact_No" class="form-control" placeholder="Contact No">
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Billing Address <span class="text-danger">*</span></label>
                                <textarea name="Billing_Address" class="form-control" rows="2" placeholder="Billing Address"></textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Mail ID</label>
                                <input type="email" name="Mail_Id" class="form-control" placeholder="Email Address">
                            </div>
                        </div>

                        <hr class="my-1">

                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div style="width:4px;height:20px;background:#00c4cc;border-radius:2px;" class="me-2"></div>
                            <h6 class="fw-bold mb-0" style="color:#1a2942;">Account Information</h6>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="filter-label">User ID <span class="text-danger">*</span></label>
                                <input type="text" name="User_Id" class="form-control" placeholder="User ID">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Account No <span class="text-danger">*</span></label>
                                <input type="text" name="Account_No" class="form-control" placeholder="Account No">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">IP Address<span class="text-danger">*</span></label>
                                <input type="text" name="IP_Addrs" class="form-control" placeholder="ip address...">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Router Details </label>
                                <input type="text" name="Router_Dtls" class="form-control"
                                    placeholder="Router Details">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Zone <span class="text-danger">*</span></label>
                                <select name="Zone_Id" id="ddl-zone" class="form-select">
                                    <option value="">-- Select Zone --</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->Id }}">
                                            {{ $zone->Cd }} — {{ $zone->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-1">

                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div style="width:4px;height:20px;background:#00c4cc;border-radius:2px;" class="me-2"></div>
                            <h6 class="fw-bold mb-0" style="color:#1a2942;">Package & Billing</h6>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="filter-label">Package <span class="text-danger">*</span></label>
                                <select id="ddl-package" class="form-select">
                                    <option value="">-- Select Package --</option>
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg->Id }}" data-basic="{{ $pkg->Basic_Amt }}"
                                            data-gst="{{ $pkg->GST_Amt }}" data-total="{{ $pkg->Total_Amt }}"
                                            data-days="{{ $pkg->Plan_Days }}">{{ $pkg->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Plan Amount</label>
                                <input type="number" name="Plan_Amount" id="txt-plan-amount" class="form-control"
                                    placeholder="0.00" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">GST</label>
                                <input type="number" name="GST" id="txt-gst" class="form-control"
                                    placeholder="0.00" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Total Amount</label>
                                <input type="number" name="Total_Amount" id="txt-total-amount" class="form-control"
                                    placeholder="0.00" readonly>
                            </div>
                        </div>

                        <hr class="my-1">

                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div style="width:4px;height:20px;background:#00c4cc;border-radius:2px;" class="me-2"></div>
                            <h6 class="fw-bold mb-0" style="color:#1a2942;">Other Information</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="filter-label">Remarks</label>
                                <input type="text" name="Remarks" class="form-control" placeholder="Remarks">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-cyan" id="saveCustomer">
                        <i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Customer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        function validateForm() {
            var checks = [{
                    sel: '[name="Cust_Code"]',
                    msg: 'Customer Code is required.'
                },
                {
                    sel: '[name="Cust_Name"]',
                    msg: 'Customer Name is required.'
                },
                {
                    sel: '[name="Join_Date"]',
                    msg: 'Join Date is required.'
                },
                {
                    sel: '[name="Billing_Address"]',
                    msg: 'Billing Address is required.'
                },
                {
                    sel: '[name="Contact_No"]',
                    msg: 'Contact No is required.'
                },
                {
                    sel: '[name="User_Id"]',
                    msg: 'User ID is required.'
                },
                {
                    sel: '[name="Account_No"]',
                    msg: 'Account No is required.'
                },
                {
                    sel: '[name="IP_Addrs"]',
                    msg: 'IP Address is required.'
                },
                {
                    sel: '[name="Zone_Id"]',
                    msg: 'Please select a Zone.'
                },
                {
                    sel: '#ddl-package',
                    msg: 'Please select a Package.'
                },
            ];
            for (var i = 0; i < checks.length; i++) {
                if (!$(checks[i].sel).val() || !$(checks[i].sel).val().trim()) {
                    Swal.fire('Validation Error', checks[i].msg, 'error');
                    return false;
                }
            }
            var custCode = $('[name="Cust_Code"]').val().trim();
            var userId = $('[name="User_Id"]').val().trim();
            var accountNo = $('[name="Account_No"]').val().trim();

            if (custCode === userId || custCode === accountNo || userId === accountNo) {
                Swal.fire('Validation Error', 'Customer Code, User ID and Account No must all be different.', 'error');
                return false;
            }
            return true;
        }

        $(document).ready(function() {

            $('#customer-table').DataTable({
                paging: false,
                info: false,
                lengthChange: false,
                searching: true,
                order: [[1, 'asc']],
                columnDefs: [{ orderable: false, targets: [8] }],
                language: {
                    search: 'Quick Search:',
                    emptyTable: 'No customers found.',
                    zeroRecords: 'No matching customers found.',
                }
            });

            @if (request()->hasAny([
                    'filter_status',
                    'filter_name',
                    'filter_wildcard',
                    'filter_payment',
                    'filter_package',
                    'filter_zone',
                    'filter_from_date',
                    'filter_to_date',
                ]))
                $('.btn-toggle-group').removeClass('active');
                $('#btn-filter-toggle').addClass('active');
                $('#filter-panel').show();
            @endif

            $('.btn-toggle-group').on('click', function(e) {
                var $btn = $(this);

                if ($btn.attr('id') === 'btn-export') {
                    e.preventDefault();
                    var url = $btn.attr('href');
                    Swal.fire({
                        title: 'Export Customers?',
                        text: 'Are you sure you want to export the customer data?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00c4cc',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Export',
                        cancelButtonText: 'Cancel'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                    return;
                }

                $('.btn-toggle-group').removeClass('active');
                $btn.addClass('active');

                if ($btn.attr('id') === 'btn-filter-toggle') {
                    $('#filter-panel').slideDown(300);
                } else {
                    $('#filter-panel').slideUp(300);
                }

                if ($btn.attr('id') === 'btn-new-customer') {
                    $('#ddl-package').prop('disabled', false);
                    var today = new Date().toISOString().split('T')[0];
                    $('[name="Join_Date"]').val(today);
                    $('#newCustomerModal').modal('show');
                }
            });

            $('#ddl-package').on('change', function() {
                var sel = $(this).find('option:selected');
                $('#hidden-package-id').val($(this).val());
                if ($(this).val()) {
                    $('#txt-plan-amount').val(sel.data('basic') || '');
                    $('#txt-gst').val(sel.data('gst') || '');
                    $('#txt-total-amount').val(sel.data('total') || '');
                } else {
                    $('#txt-plan-amount, #txt-gst, #txt-total-amount').val('');
                }
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#txt-cust-id').val(el.data('id'));
                $('[name="Cust_Code"]').val(el.data('code'));
                $('[name="Cust_Name"]').val(el.data('name'));
                $('[name="Join_Date"]').val(el.data('join'));
                $('[name="Billing_Address"]').val(el.data('address'));
                $('[name="User_Id"]').val(el.data('userid'));
                $('[name="Account_No"]').val(el.data('account'));
                $('[name="Contact_No"]').val(el.data('contact'));
                $('[name="Mail_Id"]').val(el.data('mail'));
                $('[name="IP_Addrs"]').val(el.data('ip'));
                $('[name="Router_Dtls"]').val(el.data('router'));
                $('[name="Remarks"]').val(el.data('remarks'));
                $('[name="Zone_Id"]').val(el.data('zone'));

                var pkgId = el.data('package');
                var pkgOption = $('#ddl-package option[value="' + pkgId + '"]');
                $('#ddl-package').val(pkgId);
                $('#hidden-package-id').val(pkgId);
                $('#txt-plan-amount').val(pkgOption.data('basic') || '');
                $('#txt-gst').val(pkgOption.data('gst') || '');
                $('#txt-total-amount').val(pkgOption.data('total') || '');
                $('#ddl-package').prop('disabled', true);

                $('#modalTitle').html('<i class="fas fa-user-edit me-2"></i> Edit Customer');
                $('#saveBtnText').text('Update Customer');
                $('#newCustomerModal').modal('show');
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                Swal.fire({
                    title: 'Delete Customer?',
                    text: 'Are you sure you want to delete "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.new.customer.delete') }}', {
                            Cust_Id: id,
                            _token: '{{ csrf_token() }}'
                        }, function(res) {
                            if (res.success) {
                                Swal.fire('Deleted!', res.message, 'success').then(() =>
                                    location.reload());
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        });
                    }
                });
            });


            $('#newCustomerModal').on('hidden.bs.modal', function() {
                $('#newCustomerForm')[0].reset();
                $('#txt-cust-id').val('');
                $('#txt-plan-amount, #txt-gst, #txt-total-amount').val('');
                $('#hidden-package-id').val('');
                $('#ddl-package').prop('disabled', false);
                $('#modalTitle').html('<i class="fas fa-user-plus me-2"></i> New Customer');
                $('#saveBtnText').text('Save Customer');
                $('.btn-toggle-group').removeClass('active');
                $('#btn-new-customer').addClass('active');
                $('[name="Join_Date"]').removeAttr('min');
            });

            $('#saveCustomer').on('click', function() {
                if (!validateForm()) return;

                var custId = $('#txt-cust-id').val();
                var isEdit = custId && custId !== '0';
                var url = isEdit ?
                    '{{ route('admin.new.customer.update') }}' :
                    '{{ route('admin.new.customer.store') }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#newCustomerForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Success', res.message || 'Customer saved.', 'success')
                                .then(function() {
                                    window.location.href =
                                        '{{ route('admin.new.customer') }}';
                                });
                        } else {
                            Swal.fire('Error', res.message || 'Something went wrong.', 'error');
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message : 'Server error. Please try again.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

        });
    </script>
@endpush
