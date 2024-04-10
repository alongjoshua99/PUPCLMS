<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title text-white">
                        Upload user's master list              
                </h5>

            </div>
            <form action="{{ route('admin.user.account.usermasterlist.upload') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="d-flex align-items-center">
                       
                       <label for="file" class="form-label">Choose File:</label>
                       <input type="file" class="form-control" id="file" name="file" accept=".csv, .xlsx">
                 
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="submit-e" class="btn btn-maroon">Upload</button>
                    </div>
                </form>
        </div>
    </div>
</div>
