<div class="modal fade" id="role-create-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    @include('roles.form', ['form_id_name' => 'createRoleForm'])
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
