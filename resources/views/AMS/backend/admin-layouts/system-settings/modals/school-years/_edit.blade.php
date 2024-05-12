<div class="modal fade" id="edit-school-year-{{ $school_year->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit School Year</h5>

            </div>
            <form action="{{ route('admin.system-settings.update', ['id' => $school_year->id, 'is_semester' => 0]) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-bold text-black">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ $school_year->start_date }}" name="start_date" id="start_date">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-bold text-black">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ $school_year->end_date }}" name="end_date" id="end_date">
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
