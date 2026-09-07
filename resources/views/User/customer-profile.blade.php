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

                .btn-action {
                    background-color: #f1416c;
                    border-color: #f1416c;
                    color: white;
                    font-size: 0.85rem;
                    padding: 4px 12px;
                }

                .btn-action:hover {
                    background-color: #d93a61;
                    color: white;
                }

                #btn-filter-toggle.active-filter {
                    background-color: #00c4cc !important;
                    border-color: #00c4cc !important;
                    color: white !important;
                }

                .btn-toggle-group.active {
                    background-color: #00c4cc !important;
                    border-color: #00c4cc !important;
                    color: white !important;
                }

                .page-item.active .page-link {
                    background-color: #00c4cc;
                    border-color: #00c4cc;
                    color: white;
                }

                .page-link {
                    color: #00c4cc;
                }

                .page-link:hover {
                    color: #00aeb5;
                }

                .table-responsive {
                    overflow: auto !important;
                }
            </style>

            <div class="page-title-banner shadow-sm">Customer Profile</div>

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #1a2942;">
                        <i class="fas fa-users icon-cyan me-2"></i>Customers
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Browse, filter and manage all customers across your
                        network.</p>
                </div>


            </div>

            {{-- Filters --}}
            <div class="card border-0 shadow-sm mb-4" id="filter-panel">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('customer.profile') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="filter-label">STATUS</label>
                                <select class="form-select" name="filter_status">
                                    <option value="">All Statuses</option>
                                    @foreach ($statusList as $status)
                                        <option value="{{ $status->Id }}"
                                            {{ request('filter_status') == $status->Id ? 'selected' : '' }}>
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
                                    value="{{ request('filter_wildcard') }}" placeholder="ID / Account / Mobile...">
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
                                            {{ $pkg->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">COUNTER</label>
                                <select class="form-select" name="filter_counter">
                                    <option value="">All Counters</option>
                                    @foreach ($counters as $counter)
                                        <option value="{{ $counter->Id }}"
                                            {{ request('filter_counter') == $counter->Id ? 'selected' : '' }}>
                                            {{ $counter->Name }}
                                        </option>
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
                                            {{ $zone->Cd }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-cyan w-100">
                                    <i class="fas fa-search me-2"></i> FILTER
                                </button>
                                <a href="{{ route('customer.profile') }}" class="btn btn-secondary w-100">
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
                                <div class="summary-value">{{ $summary->InActive }}</div>
                                <div class="summary-title">INACTIVE</div>
                            </div>
                            <i class="fas fa-pause-circle fs-3 icon-orange"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card summary-card border-grey bg-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-value">{{ $summary->Suspended }}</div>
                                <div class="summary-title">SUSPENDED</div>
                            </div>
                            <i class="fas fa-ban fs-3 icon-grey"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-1" style="color: #1a2942;">
                        <i class="fas fa-users icon-cyan me-2"></i> CUSTOMER DIRECTORY
                    </h6>
                    <p class="text-muted text-uppercase"
                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">
                        Filter accounts, review statuses and manage customers from one place.
                    </p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-header text-uppercase">
                                     <th class="border-top-0">Cust Name</th>
                                    <th class="border-top-0">Cust Code</th>
                                    <th class="border-top-0">User ID</th>
                                    <th class="border-top-0">Account No</th>
                                    <th class="border-top-0">Package</th>
                                    <th class="border-top-0">Exp Date</th>
                                    <th class="border-top-0">Payment Status</th>

                                </tr>
                            </thead>

                            <tbody>
                                @forelse($customers as $cust)
                                    <tr>
                                        <td>{{ $cust->Cust_Name }}</td>
                                        <td>{{ $cust->Cust_Code }}</td>
                                        <td class="text-cyan">{{ $cust->User_Id }}</td>
                                        <td>{{ $cust->Account_No }}</td>
                                        <td class="text-muted">{{ $cust->Package }}</td>
                                        <td class="text-muted">
                                            {{ $cust->Exp_Date ? date('d M Y', strtotime($cust->Exp_Date)) : '-' }}</td>
                                        <td>
                                            @if ($cust->Payment_Status === 'Paid')
                                                <span class="text-success fw-bold">Paid</span>
                                            @else
                                                <span class="text-danger-custom">Unpaid</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>



                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Showing {{ ($pageNo - 1) * $pageSize + 1 }} to {{ min($pageNo * $pageSize, $total) }} of
                            {{ $total }} entries
                        </small>
                        @if ($lastPage > 1)
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $pageNo == 1 ? 'disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pageNo - 1]) }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $lastPage; $i++)
                                    @if ($i == 1 || $i == $lastPage || abs($i - $pageNo) <= 2)
                                        <li class="page-item {{ $pageNo == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @elseif(abs($i - $pageNo) == 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endfor
                                <li class="page-item {{ $pageNo == $lastPage ? 'disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pageNo + 1]) }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection
