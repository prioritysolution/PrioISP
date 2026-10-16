@extends('Dashboard.Layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <style>
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
            </style>

            <div class="page-title-banner shadow-sm"
                style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
                Complaints
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-cyan" data-bs-toggle="modal" data-bs-target="#complainModal">
                    <i class="fas fa-plus me-1"></i> Add Complain
                </button>
            </div>

            @if ($error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Ticket No</th>
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket['number'] ?? '-' }}</td>
                                        <td>{{ $ticket['subject'] ?? '-' }}</td>
                                        <td>{{ $ticket['priority'] ?? '-' }}</td>
                                        <td>{{ $ticket['status'] ?? '-' }}</td>
                                        <td>{{ $ticket['remark'] ?? '-' }}</td>
                                        <td>{{ $ticket['updatedAt'] ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-cyan btn-view-ticket"
                                                data-number="{{ $ticket['number'] ?? '' }}">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No complaints yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewTicketModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Complaint details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="view-ticket-body">
                    <p class="text-muted mb-0">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="complainModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="complainForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Complain</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" maxlength="3800" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="LOW">Low</option>
                                <option value="MEDIUM" selected>Medium</option>
                                <option value="HIGH">High</option>
                                <option value="URGENT">Urgent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Screenshots (up to 4, 1.5 MB each)</label>
                            <input type="file" name="screenshots[]" class="form-control" accept="image/png,image/jpeg,image/webp,image/gif" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-cyan" id="btn-save-complain">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var ticketFields = [
            ['number', 'Ticket No'],
            ['subject', 'Subject'],
            ['description', 'Description'],
            ['customerName', 'Customer'],
            ['customerPhone', 'Phone'],
            ['customerEmail', 'Email'],
            ['priority', 'Priority'],
            ['status', 'Status'],
            ['remark', 'Remark'],
            ['createdAt', 'Created'],
            ['updatedAt', 'Updated']
        ];

        function ticketText(value) {
            return $('<div>').text(value === null || value === '' ? '-' : value).html();
        }

        $(document).on('click', '.btn-view-ticket', function() {
            var number = $(this).data('number');
            $('#view-ticket-body').html('<p class="text-muted mb-0">Loading...</p>');
            $('#viewTicketModal').modal('show');

            $.get('{{ url('/complaints') }}/' + encodeURIComponent(number))
                .done(function(res) {
                    if (!res.success) {
                        $('#view-ticket-body').html('<p class="text-danger mb-0">' + ticketText(res.message || 'Could not load this complaint.') + '</p>');
                        return;
                    }
                    var ticket = res.ticket || {};
                    var html = '';
                    ticketFields.forEach(function(field) {
                        html += '<p class="mb-2"><strong>' + field[1] + ':</strong> ' + ticketText(ticket[field[0]]) + '</p>';
                    });
                    var shots = ticket.screenshots || [];
                    html += '<p class="mb-2"><strong>Screenshots:</strong></p>';
                    if (!shots.length) {
                        html += '<p class="text-muted">-</p>';
                    } else {
                        html += '<div class="d-flex flex-wrap gap-3">';
                        shots.forEach(function(shot) {
                            var src = shot.url || '';
                            html += '<a href="' + ticketText(src) + '" target="_blank" rel="noopener">';
                            html += '<img src="' + ticketText(src) + '" alt="' + ticketText(shot.name || 'screenshot') + '" style="max-width:180px;max-height:140px;border:1px solid #e5e7eb;border-radius:6px;">';
                            html += '<div class="small text-muted mt-1">' + ticketText(shot.name || 'screenshot') + '</div>';
                            html += '</a>';
                        });
                        html += '</div>';
                    }
                    $('#view-ticket-body').html(html);
                })
                .fail(function(xhr) {
                    var message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Could not load this complaint.';
                    $('#view-ticket-body').html('<p class="text-danger mb-0">' + message + '</p>');
                });
        });

        $('#complainForm').on('submit', function(e) {
            e.preventDefault();
            var files = this.querySelector('input[type=file]').files;
            if (files.length > 4) {
                Swal.fire('Limit', 'You can attach up to 4 screenshots.', 'warning');
                return;
            }

            var data = new FormData(this);
            data.append('_token', '{{ csrf_token() }}');
            var $btn = $('#btn-save-complain');
            $btn.prop('disabled', true);

            $.ajax({
                url: '{{ route('support.tickets.store') }}',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Could not save the complaint.', 'error');
                        return;
                    }
                    Swal.fire('Saved', res.message + (res.number ? ' ' + res.number : ''), 'success')
                        .then(function() { window.location.reload(); });
                },
                error: function(xhr) {
                    var message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Could not save the complaint.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join(' ');
                    }
                    Swal.fire('Error', message, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
