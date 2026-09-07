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
                Package Master
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-cyan" id="btn-new-package">
                    <i class="fas fa-plus me-1"></i> New Package
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="package-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Package Name</th>
                                    <th>Type</th>
                                    <th>Basic Amt</th>
                                    <th>GST Amt</th>
                                    <th>Total Amt</th>
                                    <th>Plan Days</th>
                                    <th>Zone Comm</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $i => $p)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $p->Name }}</td>
                                        <td>{{ $p->Pack_Type_Name ?? '-' }}</td>
                                        <td>{{ number_format($p->Basic_Amt, 2) }}</td>
                                        <td>{{ number_format($p->GST_Amt, 2) }}</td>
                                        <td>{{ number_format($p->Total_Amt, 2) }}</td>
                                        <td>{{ $p->Plan_Days }}</td>
                                        <td>{!! $p->Comm_Amt == 1
                                            ? '<span class="badge bg-success">Yes</span>'
                                            : '<span class="badge bg-secondary">No</span>' !!}</td>
                                        <td>
                                            @if ($p->Is_Active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-cyan btn-edit" data-id="{{ $p->Id }}"
                                                data-type="{{ $p->Pack_Type }}" data-name="{{ $p->Name }}"
                                                data-basic="{{ $p->Basic_Amt }}" data-gst="{{ $p->GST_Amt }}"
                                                data-total="{{ $p->Total_Amt }}" data-days="{{ $p->Plan_Days }}"
                                                data-comm="{{ $p->Comm_Amt }}" data-active="{{ $p->Is_Active }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $p->Id }}"
                                                data-name="{{ $p->Name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="packageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white" id="modalTitle">
                        <i class="fas fa-plus me-2"></i> New Package
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="packageForm">
                        <input type="hidden" name="Package_Id" id="txt-package-id">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="filter-label">Package Type <span class="text-danger">*</span></label>
                                <select name="Pack_Type" class="form-select">
                                    @foreach ($packTypes as $t)
                                        <option value="{{ $t->Id }}">{{ $t->Name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-8">
                                <label class="filter-label">Package Name <span class="text-danger">*</span></label>
                                <input type="text" name="Package_Name" class="form-control" maxlength="100" required>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Basic Amount <span class="text-danger">*</span></label>
                                <input type="number" name="Basic_Amt" id="txt-basic" class="form-control" step="0.01"
                                    min="0" oninput="calcTotal()">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">GST Amount <span class="text-danger">*</span></label>
                                <input type="number" name="GST_Amt" id="txt-gst" class="form-control" step="0.01"
                                    min="0" oninput="calcTotal()">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Total Amount <span class="text-danger">*</span></label>
                                <input type="number" name="Total_Amt" id="txt-total" class="form-control" step="0.01"
                                    min="0" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Plan Days <span class="text-danger">*</span></label>
                                <input type="number" name="Plan_Days" class="form-control" min="1">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Zone Commission <span class="text-danger">*</span></label>
                                <select name="Comm_Amt" class="form-select">
                                    <option value="1">Yes (Use Zone %)</option>
                                    <option value="0">No (Zero Commission)</option>
                                </select>
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
                    <button type="button" class="btn btn-cyan" id="btn-save-package">
                        <i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Package</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function calcTotal() {
            var basic = parseFloat($('#txt-basic').val()) || 0;
            var gst = parseFloat($('#txt-gst').val()) || 0;
            $('#txt-total').val((basic + gst).toFixed(2));
        }

        $(document).ready(function() {

            $('#package-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [9]
                }]
            });

            $('#btn-new-package').on('click', function() {
                $('#packageForm')[0].reset();
                $('#txt-package-id').val('');
                $('#txt-total').val('');
                $('#modalTitle').html('<i class="fas fa-plus me-2"></i> New Package');
                $('#saveBtnText').text('Save Package');
                $('#packageModal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#txt-package-id').val(el.data('id'));
               $('[name="Pack_Type"]').val(parseInt(el.data('type')));
                $('[name="Package_Name"]').val(el.data('name'));
                $('[name="Basic_Amt"]').val(el.data('basic'));
                $('[name="GST_Amt"]').val(el.data('gst'));
                $('[name="Total_Amt"]').val(el.data('total'));
                $('[name="Plan_Days"]').val(el.data('days'));
                $('[name="Comm_Amt"]').val(parseInt(el.data('comm')));
                $('[name="Is_Active"]').val(el.data('active'));
                $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Package');
                $('#saveBtnText').text('Update Package');
                $('#packageModal').modal('show');
            });

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                Swal.fire({
                    title: 'Delete Package?',
                    text: 'Are you sure you want to delete "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.package.delete') }}', {
                            Package_Id: id,
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

            $('#btn-save-package').on('click', function() {
                if (!$('[name="Package_Name"]').val().trim()) {
                    Swal.fire('Validation Error', 'Package Name is required.', 'error');
                    return;
                }
                if (!$('[name="Basic_Amt"]').val()) {
                    Swal.fire('Validation Error', 'Basic Amount is required.', 'error');
                    return;
                }
                if (!$('[name="Plan_Days"]').val()) {
                    Swal.fire('Validation Error', 'Plan Days is required.', 'error');
                    return;
                }

                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

                $.ajax({
                    url: '{{ route('admin.package.save') }}',
                    method: 'POST',
                    data: $('#packageForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#packageModal').modal('hide');
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
                            '<i class="fas fa-save me-1"></i> <span id="saveBtnText">Save Package</span>'
                        );
                    }
                });
            });

        });
    </script>
@endpush
