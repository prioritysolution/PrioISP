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
                Counter Master
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-cyan" id="btn-new-counter">
                    <i class="fas fa-plus me-1"></i> New Counter
                </button>
            </div>

            {{-- Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="counter-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Counter Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($counters as $i => $c)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $c->Name }}</td>
                                        <td>{{ $c->Counter_Address }}</td>
                                        <td>{{ $c->Contact_No }}</td>
                                        <td>{{ $c->Email_Id }}</td>
                                        <td>
                                            @if ($c->Is_Active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-cyan btn-edit" data-id="{{ $c->Id }}"
                                                data-name="{{ $c->Name }}" data-address="{{ $c->Counter_Address }}"
                                                data-contact="{{ $c->Contact_No }}" data-email="{{ $c->Email_Id }}"
                                                data-active="{{ $c->Is_Active }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $c->Id }}"
                                                data-name="{{ $c->Name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">No counters found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="counterModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white" id="modalTitle">
                        <i class="fas fa-plus me-2"></i> New Counter
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="counterForm">
                        <input type="hidden" name="Counter_Id" id="txt-counter-id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="filter-label">Counter Name <span class="text-danger">*</span></label>
                                <input type="text" name="Counter_Name" class="form-control" maxlength="100" required>
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Contact No</label>
                                <input type="text" name="Contact_No" class="form-control" maxlength="25">
                            </div>
                            <div class="col-md-12">
                                <label class="filter-label">Address</label>
                                <textarea name="Counter_Address" class="form-control" rows="2" maxlength="200"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Email</label>
                                <input type="email" name="Email_Id" class="form-control" maxlength="75">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Status <span class="text-danger">*</span></label>
                                <select name="Is_Active" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-cyan" id="btn-save-counter">
                        <i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Counter</span>
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

            $('#counter-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [6]
                }]
            });

            $('#btn-new-counter').on('click', function() {
                $('#counterForm')[0].reset();
                $('#txt-counter-id').val('');
                $('#modalTitle').html('<i class="fas fa-plus me-2"></i> New Counter');
                $('#saveBtnText').text('Save Counter');
                $('#counterModal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#txt-counter-id').val(el.data('id'));
                $('[name="Counter_Name"]').val(el.data('name'));
                $('[name="Counter_Address"]').val(el.data('address'));
                $('[name="Contact_No"]').val(el.data('contact'));
                $('[name="Email_Id"]').val(el.data('email'));
                $('[name="Is_Active"]').val(el.data('active'));
                $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Counter');
                $('#saveBtnText').text('Update Counter');
                $('#counterModal').modal('show');
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                Swal.fire({
                    title: 'Delete Counter?',
                    text: 'Are you sure you want to delete "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.counter.delete') }}', {
                            Counter_Id: id,
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


            $('#btn-save-counter').on('click', function() {
                if (!$('[name="Counter_Name"]').val().trim()) {
                    Swal.fire('Validation Error', 'Counter Name is required.', 'error');
                    return;
                }
                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

                $.ajax({
                    url: '{{ route('admin.counter.save') }}',
                    method: 'POST',
                    data: $('#counterForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#counterModal').modal('hide');
                            Swal.fire('Success!', res.message, 'success').then(() => location
                                .reload());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong.',
                            'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Counter</span>'
                        );
                    }
                });
            });

        });
    </script>
@endpush
