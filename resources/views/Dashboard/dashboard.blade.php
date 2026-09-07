@extends('Dashboard.Layouts.layout')
@section('content')
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
                    background: linear-gradient(135deg, #0e7490 0%, #1a2942 100%);
                    border-radius: 12px;
                    padding: 22px 24px;
                    color: #fff;
                    margin-bottom: 22px;
                    position: relative;
                    overflow: hidden;
                }

                .dash-hero h3 {
                    font-weight: 700;
                    font-size: 1.3rem;
                    margin: 0 0 4px;
                }

                .dash-hero p {
                    margin: 0;
                    opacity: 0.88;
                    font-size: 0.9rem;
                }

                .counter-chip {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    background: rgba(255, 255, 255, 0.14);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    border-radius: 20px;
                    padding: 4px 12px;
                    font-size: 0.78rem;
                    font-weight: 600;
                    margin-top: 10px;
                }

                .dash-clock {
                    text-align: right;
                    position: relative;
                    z-index: 1;
                }

                .dash-clock .time {
                    font-size: 1.4rem;
                    font-weight: 700;
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
                .kpi-card.kpi-navy { border-left-color: var(--dash-navy); }

                .kpi-card .card-body { padding: 18px 20px; }

                .kpi-value {
                    font-size: 1.7rem;
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
                    font-size: 1.5rem;
                    opacity: 0.75;
                }

                .action-tile {
                    display: block;
                    background: #fff;
                    border-radius: 12px;
                    border: 1px solid var(--dash-border);
                    box-shadow: 0 2px 8px rgba(26, 41, 66, 0.05);
                    padding: 22px 18px;
                    text-align: center;
                    text-decoration: none;
                    color: var(--dash-navy);
                    height: 100%;
                    transition: all 0.2s ease;
                }

                .action-tile:hover {
                    border-color: var(--dash-cyan);
                    color: var(--dash-navy);
                    text-decoration: none;
                    transform: translateY(-3px);
                    box-shadow: 0 8px 18px rgba(0, 196, 204, 0.15);
                }

                .action-tile .tile-icon {
                    width: 54px;
                    height: 54px;
                    margin: 0 auto 12px;
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.35rem;
                    background: rgba(0, 196, 204, 0.12);
                    color: var(--dash-cyan);
                }

                .action-tile.tile-green .tile-icon {
                    background: rgba(40, 167, 69, 0.12);
                    color: var(--dash-green);
                }

                .action-tile.tile-orange .tile-icon {
                    background: rgba(253, 126, 20, 0.12);
                    color: var(--dash-orange);
                }

                .action-tile.tile-navy .tile-icon {
                    background: rgba(26, 41, 66, 0.1);
                    color: var(--dash-navy);
                }

                .action-tile h6 {
                    font-weight: 700;
                    font-size: 0.95rem;
                    margin: 0 0 4px;
                }

                .action-tile p {
                    margin: 0;
                    font-size: 0.75rem;
                    color: var(--dash-muted);
                }

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
                }

                .badge-soft-success {
                    background: rgba(40, 167, 69, 0.12);
                    color: var(--dash-green);
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

                .badge-soft-warning {
                    background: rgba(253, 126, 20, 0.12);
                    color: var(--dash-orange);
                    font-weight: 600;
                    font-size: 0.72rem;
                    padding: 4px 8px;
                    border-radius: 4px;
                }

                .hint-card {
                    background: rgba(0, 196, 204, 0.08);
                    border: 1px dashed rgba(0, 196, 204, 0.35);
                    border-radius: 10px;
                    padding: 16px 18px;
                }

                .hint-card h6 {
                    color: var(--dash-navy);
                    font-weight: 700;
                    font-size: 0.9rem;
                    margin: 0 0 6px;
                }

                .hint-card p {
                    margin: 0;
                    font-size: 0.8rem;
                    color: var(--dash-muted);
                }

                @media (max-width: 768px) {
                    .dash-hero { text-align: center; }
                    .dash-clock { text-align: center; margin-top: 12px; }
                    .kpi-value { font-size: 1.35rem; }
                }
            </style>

            <div class="dash-wrap">

                {{-- Hero --}}
                <div class="dash-hero">
                    <div class="row align-items-center">
                        <div class="col-md-8 position-relative" style="z-index:1;">
                            <h3>Welcome, {{ session('full_name') ?? 'Counter User' }}</h3>
                            <p>Your counter workspace — collect payments, generate renewal &amp; track today’s work.</p>
                            <div class="counter-chip">
                                <i class="fas fa-store"></i>
                                Counter: {{ session('counter_name') ?? '—' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dash-clock">
                                <div class="time" id="counter-clock">--:--:--</div>
                                <div class="date" id="counter-date">—</div>
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

                {{-- KPI --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ $fmtAmt($kpi->Today_Collection ?? 0) }}</div>
                                    <p class="kpi-label">Today Collection</p>
                                </div>
                                <i class="fas fa-rupee-sign kpi-icon" style="color:#00c4cc;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-green">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Receipts_Today ?? 0)) }}</div>
                                    <p class="kpi-label">Receipts Today</p>
                                </div>
                                <i class="fas fa-receipt kpi-icon" style="color:#28a745;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card kpi-card kpi-orange">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-value">{{ number_format((int) ($kpi->Unpaid_Demands ?? 0)) }}</div>
                                    <p class="kpi-label">Unpaid Demands</p>
                                </div>
                                <i class="fas fa-file-invoice-dollar kpi-icon" style="color:#fd7e14;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Primary actions --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('demand.collection') }}" class="action-tile tile-green">
                            <div class="tile-icon"><i class="fas fa-hand-holding-usd"></i></div>
                            <h6>Collect Payment</h6>
                            <p>Search customer &amp; collect due</p>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('generate.demand') }}" class="action-tile">
                            <div class="tile-icon"><i class="fas fa-bolt"></i></div>
                            <h6>Generate Renewal</h6>
                            <p>Create renewal for customer</p>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('bill.print') }}" class="action-tile tile-orange">
                            <div class="tile-icon"><i class="fas fa-print"></i></div>
                            <h6>Bill Print</h6>
                            <p>Reprint last receipt / bill</p>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('report.due.register') }}" class="action-tile tile-navy">
                            <div class="tile-icon"><i class="fas fa-list-alt"></i></div>
                            <h6>Due Register</h6>
                            <p>View unpaid demands</p>
                        </a>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Recent receipts --}}
                    <div class="col-lg-7">
                        <div class="panel-card">
                            <div class="panel-head">
                                <h6 class="panel-title"><i class="fas fa-list"></i> My Recent Receipts</h6>
                                <a href="{{ route('report.collection.register') }}" class="btn btn-sm btn-outline-secondary">Collection Register</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table dash-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Receipt</th>
                                            <th>Customer</th>
                                            <th class="text-end">Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentReceipts as $row)
                                            <tr>
                                                <td class="fw-bold" style="color:#00c4cc;">{{ $row->Receipt_No ?? '-' }}</td>
                                                <td>
                                                    {{ $row->Cust_Name }}
                                                    <br><small class="text-muted">{{ $row->Account_No }}</small>
                                                </td>
                                                <td class="text-end fw-bold">{{ $fmtAmt($row->Receipt_Amt) }}</td>
                                                <td><span class="badge-soft-success">Paid</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">No receipts yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Unpaid demands tagged to this counter --}}
                    <div class="col-lg-5">
                        <div class="panel-card mb-3">
                            <div class="panel-head">
                                <h6 class="panel-title"><i class="fas fa-file-invoice-dollar"></i> Unpaid Demands</h6>
                                <a href="{{ route('report.due.register') }}" class="btn btn-sm btn-outline-secondary">Due Register</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table dash-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th class="text-end">Due</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($unpaidDemands as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->Cust_Name }}
                                                    <br><small class="text-muted">{{ $row->Account_No }}@if(!empty($row->Inv_No)) · {{ $row->Inv_No }}@endif</small>
                                                </td>
                                                <td class="text-end fw-bold text-danger">{{ $fmtAmt($row->Due_Amt) }}</td>
                                                <td>
                                                    @php $days = (int) ($row->Due_Days ?? 0); @endphp
                                                    @if ($days > 10)
                                                        <span class="badge-soft-danger">{{ $days }} days</span>
                                                    @else
                                                        <span class="badge-soft-warning">{{ $days }} days</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">No unpaid demands.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="hint-card">
                            <h6><i class="fas fa-lightbulb me-1" style="color:#00c4cc;"></i> Counter tip</h6>
                            <p>Collect older unpaid demands first. Your pending commission updates automatically when you collect payment.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
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

    function tick() {
        var now = new Date();
        var clock = document.getElementById('counter-clock');
        var date = document.getElementById('counter-date');
        if (clock) clock.textContent = format12h(now);
        if (date) date.textContent = now.toLocaleDateString('en-IN', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endpush
