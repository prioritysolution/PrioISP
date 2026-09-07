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
                Zone Master
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-cyan" id="btn-new-zone">
                    <i class="fas fa-plus me-1"></i> New Zone
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="zone-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Zone Code</th>
                                    <th>LCO Name</th>
                                    <th>Operator Name</th>
                                    <th>Comm %</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($zones as $i => $z)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $z->Cd }}</td>
                                        <td>{{ $z->Name }}</td>
                                        <td>{{ $z->OpNm }}</td>
                                        <td>{{ $z->Comm_Pct ?? '0.00' }}%</td>
                                        <td>
                                            @if ($z->Is_Active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-cyan btn-edit" data-id="{{ $z->Id }}"
                                                data-cd="{{ $z->Cd }}" data-lco="{{ $z->Name }}"
                                                data-operator="{{ $z->OpNm }}" data-commpct="{{ $z->Comm_Pct ?? 0 }}"
                                                data-active="{{ $z->Is_Active }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $z->Id }}"
                                                data-name="{{ $z->Name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No zones found.</td>
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
    <div class="modal fade" id="zoneModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white" id="modalTitle">
                        <i class="fas fa-plus me-2"></i> New Zone
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="zoneForm">
                        <input type="hidden" name="Zone_Id" id="txt-zone-id">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="filter-label">Zone Code <span class="text-danger">*</span></label>
                                <input type="text" name="Zone_Cd" class="form-control" maxlength="50" required>
                            </div>
                            <div class="col-md-4">
                                <label class="filter-label">LCO Name <span class="text-danger">*</span></label>
                                <input type="text" name="LCO_Name" class="form-control" maxlength="100" required>
                            </div>
                            <div class="col-md-4">
                                <label class="filter-label">Operator Name<span class="text-danger">*</span></label>
                                <input type="text" name="Operator_Name" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-4">
                                <label class="filter-label">Commission %<span class="text-danger">*</span> </label>
                                <input type="number" name="Comm_Pct" class="form-control" min="0" max="100"
                                    step="0.01" placeholder="0.00">
                            </div>
                            <div class="col-md-4" id="div-eff-from" style="display:none;">
                                <label class="filter-label">Effect From <span class="text-danger">*</span></label>
                                <input type="date" name="Eff_From" id="txt-eff-from" class="form-control">
                            </div>


                            <div class="col-md-4">
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
                    <button type="button" class="btn btn-cyan" id="btn-save-zone">
                        <i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Zone</span>
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
            $('#zone-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [6]
                }]
            });

            $('#btn-new-zone').on('click', function() {
                $('#zoneForm')[0].reset();
                $('#txt-zone-id').val('');
                $('#div-eff-from').hide();
                $('[name="Eff_From"]').val('');
                $('#modalTitle').html('<i class="fas fa-plus me-2"></i> New Zone');
                $('#saveBtnText').text('Save Zone');
                $('#zoneModal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#txt-zone-id').val(el.data('id'));
                $('[name="Zone_Cd"]').val(el.data('cd'));
                $('[name="LCO_Name"]').val(el.data('lco'));
                $('[name="Operator_Name"]').val(el.data('operator'));
                $('[name="Comm_Pct"]').val(el.data('commpct'));
                $('[name="Is_Active"]').val(el.data('active'));
                $('#div-eff-from').show();
                $('[name="Eff_From"]').val(new Date().toISOString().split('T')[0]);
                $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Zone');
                $('#saveBtnText').text('Update Zone');
                $('#zoneModal').modal('show');
            });

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                Swal.fire({
                    title: 'Delete Zone?',
                    text: 'Are you sure you want to delete "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.zone.delete') }}', {
                            Zone_Id: id,
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

            $('#btn-save-zone').on('click', function() {
                if (!$('[name="Zone_Cd"]').val().trim()) {
                    Swal.fire('Validation Error', 'Zone Code is required.', 'error');
                    return;
                }
                if (!$('[name="LCO_Name"]').val().trim()) {
                    Swal.fire('Validation Error', 'LCO Name is required.', 'error');
                    return;
                }

                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

                $.ajax({
                    url: '{{ route('admin.zone.save') }}',
                    method: 'POST',
                    data: $('#zoneForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#zoneModal').modal('hide');
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
                            '<i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Zone</span>'
                        );
                    }
                });
            });

        });
    </script>
@endpush
