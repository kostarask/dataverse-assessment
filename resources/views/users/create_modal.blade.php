<div class="modal fade" id="user-create-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    @include('users.form', ['form_id_name' => 'userCreateForm'])
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
