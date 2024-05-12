<div class="modal fade" id="edit-semester-{{ $semester->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Semester</h5>

            </div>
            <form action="{{ route('admin.system-settings.update', ['id' => $semester->id, 'is_semester' => 1]) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="start_date" class="form-label fw-bold text-black">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $semester->start_date }}">
                        </div>
                        <div class="col-6">
                            <label for="end_date" class="form-label fw-bold text-black">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $semester->end_date }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
