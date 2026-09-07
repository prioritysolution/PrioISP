@extends('Dashboard.Layouts.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <div class="page-wrapper">
        <div class="content">

            <style>
                :root {
                    --dash-navy: #1a2942;
                    --dash-cyan: #00c4cc;
                    --dash-cyan-dark: #00aeb5;
                    --dash-green: #28a745;
                    --dash-orange: #fd7e14;
                    --dash-red: #dc3545;
                    --dash-muted: #6c757d;
                    --dash-bg: #f4f6f9;
                    --dash-border: #e9ecef;
                }

                .dash-wrap {
                    background: var(--dash-bg);
                    margin: -24px -15px -15px;
                    padding: 24px 15px 40px;
                    min-height: calc(100vh - 120px);
                }

                .dash-hero {
                    background: linear-gradient(135deg, #1a2942 0%, #243b55 55%, #0e7490 100%);
                    border-radius: 12px;
                    padding: 22px 24px;
                    color: #fff;
                    margin-bottom: 22px;
                    position: relative;
                    overflow: hidden;
                }

                .dash-hero h3 {
                    font-weight: 700;
                    font-size: 1.35rem;
                    margin: 0 0 4px;
                }

                .dash-hero p {
                    margin: 0;
                    opacity: 0.85;
                    font-size: 0.9rem;
                }

                .dash-clock {
                    text-align: right;
                    position: relative;
                    z-index: 1;
                }

                .dash-clock .time {
                    font-size: 1.4rem;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                }

                .dash-clock .date {
                    font-size: 0.78rem;
                    opacity: 0.8;
                }

                .kpi-card {
                    background: #fff;
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(26, 41, 66, 0.06);
                    height: 100%;
                    border-left: 4px solid var(--dash-cyan);
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                }

                .kpi-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 16px rgba(26, 41, 66, 0.1);
                }

                .kpi-card.kpi-green { border-left-color: var(--dash-green); }
                .kpi-card.kpi-orange { border-left-color: var(--dash-orange); }
                .kpi-card.kpi-red { border-left-color: var(--dash-red); }
                .kpi-card.kpi-navy { border-left-color: var(--dash-navy); }
                .kpi-card.kpi-grey { border-left-color: #adb5bd; }

                .kpi-card .card-body {
                    padding: 18px 20px;
                }

                .kpi-value {
                    font-size: 1.75rem;
                    font-weight: 700;
                    color: var(--dash-navy);
                    line-height: 1.1;
                    margin-bottom: 6px;
                }

                .kpi-label {
                    font-size: 0.72rem;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.04em;
                    color: var(--dash-muted);
                    margin: 0;
                }

                .kpi-icon {
                    font-size: 1.6rem;
                    opacity: 0.7;
                }

                .kpi-icon.cyan { color: var(--dash-cyan); }
                .kpi-icon.green { color: var(--dash-green); }
                .kpi-icon.orange { color: var(--dash-orange); }
                .kpi-icon.red { color: var(--dash-red); }
                .kpi-icon.navy { color: var(--dash-navy); }

                .panel-card {
                    background: #fff;
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(26, 41, 66, 0.06);
                    height: 100%;
                }

                .panel-card .panel-head {
                    padding: 14px 18px;
                    border-bottom: 1px solid var(--dash-border);
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 10px;
                }

                .panel-card .panel-head .panel-actions {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    flex-shrink: 0;
                    margin-left: auto;
                }

                .panel-card .panel-head .panel-actions .select2-wrap {
                    width: 170px;
                    flex: 0 0 170px;
                }

                .panel-card .panel-head .panel-actions .select2-wrap .select2-container {
                    width: 100% !important;
                }

                .panel-card .panel-head .btn-view-all {
                    display: inline-flex !important;
                    align-items: center;
                    justify-content: center;
                    flex: 0 0 auto;
                    height: 32px;
                    min-width: 88px;
                    padding: 0 14px;
                    border: none;
                    border-radius: 6px;
                    background: #00c4cc !important;
                    color: #fff !important;
                    font-size: 0.78rem;
                    font-weight: 600;
                    text-decoration: none !important;
                    white-space: nowrap;
                    line-height: 1;
                    box-shadow: none;
                }

                .panel-card .panel-head .btn-view-all:hover,
                .panel-card .panel-head .btn-view-all:focus {
                    background: #00aeb5 !important;
                    color: #fff !important;
                }

                .panel-card .panel-head .select2-container .select2-selection--single {
                    height: 32px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                }

                .panel-card .panel-head .select2-container .select2-selection--single .select2-selection__rendered {
                    line-height: 30px;
                    font-size: 0.78rem;
                    color: #1a2942;
                    padding-left: 10px;
                }

                .panel-card .panel-head .select2-container .select2-selection--single .select2-selection__arrow {
                    height: 30px;
                }

                .panel-card .panel-head .select2-container--default.select2-container--focus .select2-selection--single,
                .panel-card .panel-head .select2-container--default.select2-container--open .select2-selection--single {
                    border-color: #00c4cc;
                }

                .bar-total {
                    margin-top: 12px;
                    padding-top: 12px;
                    border-top: 1px dashed var(--dash-border);
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .bar-total .label {
                    font-size: 0.82rem;
                    font-weight: 700;
                    color: var(--dash-navy);
                }

                .bar-total .amt {
                    font-size: 0.95rem;
                    font-weight: 700;
                    color: var(--dash-cyan);
                }

                .panel-card .panel-title {
                    margin: 0;
                    font-size: 0.85rem;
                    font-weight: 700;
                    color: var(--dash-navy);
                    text-transform: uppercase;
                    letter-spacing: 0.04em;
                }

                .panel-card .panel-title i {
                    color: var(--dash-cyan);
                    margin-right: 6px;
                }

                .panel-card .panel-body {
                    padding: 16px 18px;
                }

                .quick-action {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 14px 16px;
                    border: 1px solid var(--dash-border);
                    border-radius: 8px;
                    text-decoration: none;
                    color: var(--dash-navy);
                    background: #fff;
                    transition: all 0.2s ease;
                    height: 100%;
                }

                .quick-action:hover {
                    border-color: var(--dash-cyan);
                    color: var(--dash-navy);
                    background: rgba(0, 196, 204, 0.06);
                    text-decoration: none;
                }

                .quick-action .qa-icon {
                    width: 40px;
                    height: 40px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: rgba(0, 196, 204, 0.12);
                    color: var(--dash-cyan);
                    flex-shrink: 0;
                }

                .quick-action .qa-label {
                    font-weight: 700;
                    font-size: 0.88rem;
                    margin: 0;
                }

                .quick-action .qa-sub {
                    font-size: 0.72rem;
                    color: var(--dash-muted);
                    margin: 0;
                }

                .dash-table {
                    width: 100%;
                    margin: 0;
                }

                .dash-table th {
                    font-size: 0.72rem;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: var(--dash-muted);
                    background: #f8f9fa;
                    border: none;
                    padding: 10px 12px;
                }

                .dash-table td {
                    font-size: 0.85rem;
                    vertical-align: middle;
                    border-color: #f1f1f1;
                    padding: 11px 12px;
                    color: #343a40;
                }

                .badge-soft-success {
                    background: rgba(40, 167, 69, 0.12);
                    color: var(--dash-green);
                    font-weight: 600;
                    font-size: 0.72rem;
                    padding: 4px 8px;
                    border-radius: 4px;
                }

                .badge-soft-warning {
                    background: rgba(253, 126, 20, 0.12);
                    color: var(--dash-orange);
                    font-weight: 600;
                    font-size: 0.72rem;
                    padding: 4px 8px;
                    border-radius: 4px;
                }

                .badge-soft-danger {
                    background: rgba(220, 53, 69, 0.12);
                    color: var(--dash-red);
                    font-weight: 600;
                    font-size: 0.72rem;
                    padding: 4px 8px;
                    border-radius: 4px;
                }

                .badge-soft-info {
                    background: rgba(0, 196, 204, 0.12);
                    color: var(--dash-cyan-dark);
                    font-weight: 600;
                    font-size: 0.72rem;
                    padding: 4px 8px;
                    border-radius: 4px;
                }

                .bar-row {
                    margin-bottom: 14px;
                }

                .bar-row:last-child {
                    margin-bottom: 0;
                }

                .bar-meta {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 5px;
                    font-size: 0.8rem;
                }

                .bar-meta .name {
                    font-weight: 600;
                    color: var(--dash-navy);
                }

                .bar-meta .amt {
                    color: var(--dash-muted);
                    font-weight: 600;
                }

                .bar-track {
                    height: 8px;
                    background: #eef1f4;
                    border-radius: 6px;
                    overflow: hidden;
                }

                .bar-fill {
                    height: 100%;
                    background: linear-gradient(90deg, var(--dash-cyan), #0e7490);
                    border-radius: 6px;
                }

                .attn-item {
                    display: flex;
                    align-items: flex-start;
                    gap: 10px;
                    padding: 12px 0;
                    border-bottom: 1px solid #f1f1f1;
                }

                .attn-item:last-child {
                    border-bottom: none;
                    padding-bottom: 0;
                }

                .attn-dot {
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    margin-top: 6px;
                    flex-shrink: 0;
                }

                .attn-dot.warn { background: var(--dash-orange); }
                .attn-dot.danger { background: var(--dash-red); }
                .attn-dot.info { background: var(--dash-cyan); }

                .attn-text {
                    font-size: 0.85rem;
                    color: var(--dash-navy);
                    font-weight: 600;
                    margin: 0 0 2px;
                }

                .attn-sub {
                    font-size: 0.75rem;
                    color: var(--dash-muted);
                    margin: 0;
                }

                @media (max-width: 768px) {
                    .dash-hero {
                        text-align: center;
                    }
                    .dash-clock {
                        text-align: center;
                        margin-top: 12px;
                    }
                    .kpi-value {
                        font-size: 1.4rem;
                    }
                }
            </style>

            <div class="dash-wrap">

                {{-- Hero --}}
                <div class="dash-hero">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3><i class="fas fa-chart-pie me-2" style="color:#00c4cc;"></i>Admin Dashboard</h3>
                            <p>Network billing overview — customers, collections, dues &amp; commission at a glance.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="dash-clock">
                                <div class="time" id="admin-clock">--:--:--</div>
                                <div class="date" id="admin-date">—</div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $fmtAmt = function ($v) {
                        $n = (float) ($v ?? 0);
                        if ($n >= 100000) {
                            return '₹ ' . number_format($n / 100000, 2) . 'L';
                        }
                        return '₹ ' . number_format($n, 2);
                    };
                @endphp

                {{-- KPI cards: 2 rows x 3 --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Total_Customers ?? 0)) }}</div>
                                    <p class="kpi-label">Total Customers</p>
                                </div>
                                <i class="fas fa-users kpi-icon cyan"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-green">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Active_Customers ?? 0)) }}</div>
                                    <p class="kpi-label">Active</p>
                                </div>
                                <i class="fas fa-check-circle kpi-icon green"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-orange">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ $fmtAmt($kpi->Today_Collection ?? 0) }}</div>
                                    <p class="kpi-label">Today Collection</p>
                                </div>
                                <i class="fas fa-rupee-sign kpi-icon orange"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-red">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ $fmtAmt($kpi->Total_Due ?? 0) }}</div>
                                    <p class="kpi-label">Total Due</p>
                                </div>
                                <i class="fas fa-exclamation-circle kpi-icon red"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-navy">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Unpaid_Demands ?? 0)) }}</div>
                                    <p class="kpi-label">Unpaid Demands</p>
                                </div>
                                <i class="fas fa-file-invoice kpi-icon navy"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-grey">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Suspended_Customers ?? 0)) }}</div>
                                    <p class="kpi-label">Suspended</p>
                                </div>
                                <i class="fas fa-ban kpi-icon" style="color:#adb5bd;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.new.customer') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-users"></i></div>
                            <div>
                                <p class="qa-label">Customers</p>
                                <p class="qa-sub">Manage accounts</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.generate.demand') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-bolt"></i></div>
                            <div>
                                <p class="qa-label">Generate Renewal</p>
                                <p class="qa-sub">Create renewal</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.demand.collection') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-hand-holding-usd"></i></div>
                            <div>
                                <p class="qa-label">Collection</p>
                                <p class="qa-sub">Receive payment</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.counterwisecollection') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-store"></i></div>
                            <div>
                                <p class="qa-label">Counter Wise</p>
                                <p class="qa-sub">Collection report</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.commission.register') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-percent"></i></div>
                            <div>
                                <p class="qa-label">Zone Commission</p>
                                <p class="qa-sub">LCO register</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('admin.report.due.register') }}" class="quick-action">
                            <div class="qa-icon"><i class="fas fa-list-alt"></i></div>
                            <div>
                                <p class="qa-label">Due Register</p>
                                <p class="qa-sub">Outstanding dues</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Recent collections --}}
                    <div class="col-lg-7">
                        <div class="panel-card">
                            <div class="panel-head">
                                <h6 class="panel-title mb-0"><i class="fas fa-receipt"></i> Recent Collections</h6>
                                <div class="panel-actions">
                                    <div class="select2-wrap">
                                        <select id="rc-counter-filter" class="form-select form-select-sm">
                                            <option value="0">All</option>
                                            <option value="-1">Admin</option>
                                            @foreach (($counters ?? []) as $c)
                                                <option value="{{ $c->Counter_Id }}">{{ $c->Counter_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a href="{{ route('admin.report.collection.register') }}" class="btn-view-all">View All</a>
                                </div>
                            </div>
                            <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table dash-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Receipt</th>
                                                <th>Customer</th>
                                                <th>Counter</th>
                                                <th>Admin</th>
                                                <th class="text-end">Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rc-tbody">
                                            @forelse ($recentCollections as $row)
                                                <tr>
                                                    <td class="fw-bold" style="color:#00c4cc;">{{ $row->Receipt_No ?? '-' }}</td>
                                                    <td>
                                                        {{ $row->Cust_Name }}
                                                        <br><small class="text-muted">{{ $row->Account_No }}</small>
                                                    </td>
                                                    <td>{{ $row->Counter_Name ?? '-' }}</td>
                                                    <td>
                                                        @if (($row->Admin_Label ?? '-') === 'Admin')
                                                            <span class="badge-soft-warning">Admin</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-end fw-bold">{{ $fmtAmt($row->Receipt_Amt) }}</td>
                                                    <td><span class="badge-soft-success">Paid</span></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">No recent collections.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Counter wise today (+ Admin separate) --}}
                    <div class="col-lg-5">
                        <div class="panel-card">
                            <div class="panel-head">
                                <h6 class="panel-title"><i class="fas fa-store"></i> Counter Collection Today</h6>
                            </div>
                            <div class="panel-body">
                                @php
                                    $todayCollTotal = 0;
                                    foreach (($counterCollections ?? []) as $ctrRow) {
                                        $todayCollTotal += (float) ($ctrRow->Coll_Amt ?? 0);
                                    }
                                @endphp
                                @forelse ($counterCollections as $ctr)
                                    <div class="bar-row">
                                        <div class="bar-meta">
                                            <span class="name">
                                                {{ $ctr->Counter_Name }}
                                                @if (!empty($ctr->Is_Admin))
                                                    <small class="text-muted">(not a counter)</small>
                                                @endif
                                            </span>
                                            <span class="amt">{{ $fmtAmt($ctr->Coll_Amt) }}</span>
                                        </div>
                                        <div class="bar-track">
                                            <div class="bar-fill" style="width:{{ $ctr->Bar_Pct ?? 0 }}%;{{ !empty($ctr->Is_Admin) ? 'background:#fd7e14;' : '' }}"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0 small">No collection today.</p>
                                @endforelse
                                @if (!empty($counterCollections))
                                    <div class="bar-total">
                                        <span class="label">Total</span>
                                        <span class="amt">{{ $fmtAmt($todayCollTotal) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
(function () {
    function format12h(date) {
        var h = date.getHours();
        var m = String(date.getMinutes()).padStart(2, '0');
        var s = String(date.getSeconds()).padStart(2, '0');
        var ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        if (h === 0) h = 12;
        return h + ':' + m + ':' + s + ' ' + ampm;
    }

    function formatAmt(v) {
        var n = parseFloat(v) || 0;
        if (n >= 100000) return '₹ ' + (n / 100000).toFixed(2) + 'L';
        return '₹ ' + n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function tick() {
        var now = new Date();
        var clock = document.getElementById('admin-clock');
        var date = document.getElementById('admin-date');
        if (clock) clock.textContent = format12h(now);
        if (date) date.textContent = now.toLocaleDateString('en-IN', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }
    tick();
    setInterval(tick, 1000);

    function renderRows(rows) {
        var tbody = document.getElementById('rc-tbody');
        if (!tbody) return;
        if (!rows || !rows.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No recent collections.</td></tr>';
            return;
        }
        var html = '';
        rows.forEach(function (row) {
            var adminCell = (row.Admin_Label === 'Admin')
                ? '<span class="badge-soft-warning">Admin</span>'
                : '-';
            html += '<tr>' +
                '<td class="fw-bold" style="color:#00c4cc;">' + (row.Receipt_No || '-') + '</td>' +
                '<td>' + (row.Cust_Name || '-') + '<br><small class="text-muted">' + (row.Account_No || '') + '</small></td>' +
                '<td>' + (row.Counter_Name || '-') + '</td>' +
                '<td>' + adminCell + '</td>' +
                '<td class="text-end fw-bold">' + formatAmt(row.Receipt_Amt) + '</td>' +
                '<td><span class="badge-soft-success">Paid</span></td>' +
                '</tr>';
        });
        tbody.innerHTML = html;
    }

    var $filter = $('#rc-counter-filter');
    $filter.select2({
        width: '100%',
        placeholder: 'Select counter',
        allowClear: false,
        minimumResultsForSearch: 0,
        dropdownParent: $('.panel-actions .select2-wrap')
    });

    $filter.on('change', function () {
        var filter = $(this).val();
        var tbody = $('#rc-tbody');
        tbody.html('<tr><td colspan="6" class="text-center text-muted py-4">Loading...</td></tr>');
        $.get('{{ route('dashboard.recent.collections') }}', { filter: filter }, function (res) {
            if (res.success) {
                renderRows(res.rows);
            } else {
                tbody.html('<tr><td colspan="6" class="text-center text-danger py-4">Failed to load.</td></tr>');
            }
        }).fail(function () {
            tbody.html('<tr><td colspan="6" class="text-center text-danger py-4">Failed to load.</td></tr>');
        });
    });
})();
</script>
@endpush
