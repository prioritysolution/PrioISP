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
            </style>

            <div class="page-title-banner shadow-sm"
                style="border:1px solid #1a2942;border-radius:8px;padding:12px;text-align:center;font-weight:600;font-size:1.25rem;color:#1a2942;background:#fff;margin-bottom:24px;">
                User Setup
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-cyan" id="btn-new-user">
                    <i class="fas fa-plus me-1"></i> New User
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <div class="card-body px-4 pb-4">
                        <table class="table table-hover mb-0" id="user-table">
                            <thead>
                                <tr class="table-header text-uppercase">
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Counter</th>
                                    <th>User Type</th>
                                    <th>Admin</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $i => $u)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $u->Full_Name }}</td>
                                        <td>{{ $u->User_Name }}</td>
                                        <td>{{ $u->Counter_Name ?? '-' }}</td>
                                        <td>
                                            @if ($u->User_Type == 1)
                                                Admin
                                            @elseif ($u->User_Type == 2)
                                                LCO
                                            @else
                                                Staff
                                            @endif
                                        </td>
                                        <td>
                                            @if ($u->Is_Admin)
                                                <span class="badge bg-primary">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($u->Is_Active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-cyan btn-edit" data-id="{{ $u->User_Id }}"
                                                data-fullname="{{ $u->Full_Name }}" data-username="{{ $u->User_Name }}"
                                                data-counter="{{ $u->Counter_Id }}" data-usertype="{{ $u->User_Type }}"
                                                data-isadmin="{{ $u->Is_Admin == 1 ? '1' : '0' }}"
                                                data-isactive="{{ $u->Is_Active }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete ms-1"
                                                data-id="{{ $u->User_Id }}" data-name="{{ $u->Full_Name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <button class="btn btn-sm btn-warning btn-menus ms-1"
                                                data-id="{{ $u->User_Id }}" data-name="{{ $u->Full_Name }}">
                                                <i class="fas fa-bars"></i> Menus
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No users found.</td>
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
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white" id="modalTitle">
                        <i class="fas fa-user-plus me-2"></i> New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="userForm">
                        <input type="hidden" name="User_Id" id="txt-user-id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="filter-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="Full_Name" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="User_Name" class="form-control" maxlength="75">
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Password <span class="text-danger"
                                        id="pwd-required">*</span></label>
                                <input type="password" name="Password" id="txt-password" class="form-control"
                                    maxlength="100" placeholder="password">
                            </div>
                            <div class="col-md-6">
                                <label class="filter-label">Counter <span class="text-danger">*</span></label>
                                <select name="Counter_Id" class="form-select">
                                    <option value="">-- Select Counter --</option>
                                    @foreach ($counters as $c)
                                        <option value="{{ $c->Counter_Id }}">{{ $c->Counter_Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="filter-label">User Type <span class="text-danger">*</span></label>
                                <select name="User_Type" class="form-select">
                                    <option value="1">Admin</option>
                                    <option value="0">Staff</option>
                                    <option value="2">LCO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="filter-label">Is Admin <span class="text-danger">*</span></label>
                                <select name="Is_Admin" class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
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
                    <button type="button" class="btn btn-cyan" id="btn-save-user">
                        <i class="fas fa-save me-1"></i> <span id="saveBtnText">Save User</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Modal --}}
    <div class="modal fade" id="menuModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1a2942;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-bars me-2"></i> Menu Access —
                        <span id="menu-user-name"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="menu-modal-body">
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-cyan" id="btn-save-menus">
                        <i class="fas fa-save me-1"></i> Save Menus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var currentMenuUserId = null;

        function renderMenuModal(res) {
            if (!res.success) {
                $('#menu-modal-body').html('<div class="text-danger p-3">Failed to load menus.</div>');
                return;
            }

            var groups = {};
            $.each(res.menus, function(i, m) {
                if (!groups[m.Menu_Id]) groups[m.Menu_Id] = {
                    label: '',
                    slNo: null,
                    items: []
                };
                if (m.MnuName !== '') {
                    groups[m.Menu_Id].label = m.MnuName;
                    groups[m.Menu_Id].slNo = m.Sl;
                } else {
                    groups[m.Menu_Id].items.push(m);
                }
            });

            var html = '<div class="row g-3">';
            $.each(groups, function(menuId, grp) {
                if (!grp.label) return; // skip if no parent label
                html += '<div class="col-md-6"><div class="card border shadow-sm">';
                html += '<div class="card-header bg-light py-2"><div class="form-check">';
                var isDashboard = (grp.slNo == 1);
                html += '<input type=\"checkbox\" class=\"form-check-input chk-parent\" id=\"chk_p_' + grp.slNo +
                    '\" value=\"' + grp.slNo + '\"' +
                    (isDashboard ? ' checked disabled' : '') + '>';

                html += '<label class="form-check-label fw-bold" for="chk_p_' + grp.slNo + '">' + grp.label +
                    '</label>';
                html += '</div></div>';
                if (grp.items.length > 0) {
                    html += '<div class="card-body py-2">';
                    $.each(grp.items, function(j, sub) {
                        html += '<div class="form-check">';
                        html +=
                            '<input type="checkbox" class="form-check-input chk-sub" data-parent="chk_p_' +
                            grp.slNo + '" id="chk_s_' + sub.Sl + '" value="' + sub.Sl + '">';
                        html += '<label class="form-check-label" for="chk_s_' + sub.Sl + '">' + sub
                            .SubMnuName + '</label>';
                        html += '</div>';
                    });
                    html += '</div>';
                }
                html += '</div></div>';
            });
            html += '</div>';

            $('#menu-modal-body').html(html);

            // now tick assigned checkboxes
            $.each(res.assigned, function(i, sl) {
                $('#chk_s_' + sl + ', #chk_p_' + sl).prop('checked', true);
            });

            // sync parent state based on subs
            $.each(groups, function(menuId, grp) {
                if (grp.items.length > 0) {
                    var allChecked = true;
                    $.each(grp.items, function(j, sub) {
                        if (res.assigned.indexOf(sub.Sl) === -1) allChecked = false;
                    });
                    $('#chk_p_' + grp.slNo).prop('checked', allChecked);
                }
            });
        }

        $(document).ready(function() {

            $('#user-table').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [7]
                }]
            });

            $('#btn-new-user').on('click', function() {
                $('#userForm')[0].reset();
                $('#txt-user-id').val('');
                $('#txt-password').attr('placeholder', 'Enter password');
                $('#pwd-required').show();
                $('#modalTitle').html('<i class="fas fa-user-plus me-2"></i> New User');
                $('#saveBtnText').text('Save User');
                $('#userModal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                var el = $(this);
                $('#txt-user-id').val(el.data('id'));
                $('[name="Full_Name"]').val(el.data('fullname'));
                $('[name="User_Name"]').val(el.data('username'));
                $('[name="Counter_Id"]').val(el.data('counter'));
                $('[name="User_Type"]').val(el.data('usertype'));
                $('[name="Is_Admin"]').val(el.data('isadmin'));
                $('[name="Is_Active"]').val(el.data('isactive'));
                $('[name="Password"]').val('');
                $('#txt-password').attr('placeholder', 'update password');
                $('#pwd-required').hide();
                $('#modalTitle').html('<i class="fas fa-user-edit me-2"></i> Edit User');
                $('#saveBtnText').text('Update User');
                $('#userModal').modal('show');
            });

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                Swal.fire({
                    title: 'Delete User?',
                    text: 'Are you sure you want to delete "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.user.setup.delete') }}', {
                            User_Id: id,
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

            // open menu modal from Menus button
            $(document).on('click', '.btn-menus', function() {
                currentMenuUserId = $(this).data('id');
                $('#menu-user-name').text($(this).data('name'));
                $('#menu-modal-body').html(
                    '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>'
                );
                $('#menuModal').modal('show');
                $.get('{{ route('admin.user.setup.menus') }}', {
                    user_id: currentMenuUserId
                }, function(res) {
                    renderMenuModal(res);
                });
            });

            // parent toggle → check/uncheck all subs
            $(document).on('change', '.chk-parent', function() {
                var parentId = $(this).attr('id');
                var isChecked = $(this).is(':checked');
                $('.chk-sub[data-parent="' + parentId + '"]').prop('checked', isChecked);
            });

            // sub toggle → sync parent
            $(document).on('change', '.chk-sub', function() {
                var parentId = $(this).data('parent');
                var allChecked = true;
                $('.chk-sub[data-parent="' + parentId + '"]').each(function() {
                    if (!$(this).is(':checked')) allChecked = false;
                });
                $('#' + parentId).prop('checked', allChecked);
            });

            // save menus
            $('#btn-save-menus').on('click', function() {
                var selected = [];
                $('#menu-modal-body input[type="checkbox"]:checked, #menu-modal-body input[type="checkbox"][disabled]')
                    .each(function() {
                        selected.push($(this).val());
                    });

                $.post('{{ route('admin.user.setup.menus.save') }}', {
                    user_id: currentMenuUserId,
                    menu_sls: selected.join(','),
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    if (res.success) {
                        $('#menuModal').modal('hide');
                        Swal.fire('Saved!', res.message, 'success');
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                });
            });

            // save user
            $('#btn-save-user').on('click', function() {
                var isNew = !$('#txt-user-id').val();

                if (!$('[name="Full_Name"]').val().trim()) {
                    Swal.fire('Validation', 'Full Name is required.', 'error');
                    return;
                }
                if (!$('[name="User_Name"]').val().trim()) {
                    Swal.fire('Validation', 'Username is required.', 'error');
                    return;
                }
                if (!$('[name="Counter_Id"]').val()) {
                    Swal.fire('Validation', 'Counter is required.', 'error');
                    return;
                }
                if (isNew && !$('[name="Password"]').val()) {
                    Swal.fire('Validation', 'Password is required for new user.', 'error');
                    return;
                }

                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

                $.ajax({
                    url: '{{ route('admin.user.setup.save') }}',
                    method: 'POST',
                    data: $('#userForm').serialize() + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if (res.success) {
                            $('#userModal').modal('hide');
                            if (res.is_new && res.new_user_id) {
                                Swal.fire({
                                    title: 'User Saved!',
                                    text: 'Assign menus for this user now?',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonColor: '#00c4cc',
                                    confirmButtonText: 'Yes, Assign Menus',
                                    cancelButtonText: 'Skip'
                                }).then(function(r) {
                                    if (r.isConfirmed) {
                                        currentMenuUserId = res.new_user_id;
                                        $('#menu-user-name').text($(
                                            '[name="Full_Name"]').val());
                                        $('#menu-modal-body').html(
                                            '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>'
                                        );
                                        $('#menuModal').modal('show');
                                        $.get('{{ route('admin.user.setup.menus') }}', {
                                            user_id: res.new_user_id
                                        }, function(menuRes) {
                                            renderMenuModal(menuRes);
                                        });
                                    } else {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Success!', res.message, 'success').then(() =>
                                    location.reload());
                            }
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
                            '<i class="fas fa-save me-1"></i> <span id="saveBtnText">Save User</span>'
                        );
                    }
                });
            });

        });
    </script>
@endpush
