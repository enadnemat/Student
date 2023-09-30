<!-- update modal -->
<div class="modal fade" id="updateModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="userUsername" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="userEmail" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="is_active">Active</label>
                    <select id='is_active' class="form-control">
                        <option value='1'>Active</option>
                        <option value='0'>Inactive</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" id="txt_empid" value="0">
                <button type="button" class="btn btn-success" id="btn_save">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
