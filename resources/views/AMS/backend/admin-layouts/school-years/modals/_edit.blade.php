<div class="modal fade" id="edit{{ $school_year->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit School Year</h5>

            </div>
            <form action="{{ route('admin.school-year.update', ['id' => $school_year->id]) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-bold text-black">School Year</label>
                            <input type="text" class="form-control" name="name" id="name" readonly value="{{ $school_year->name }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="semester_id" class="form-label fw-bold text-black">Semester</label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" name="semester_id"
                                id="status">
                                <option value="">Select Status</option>
                                @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ ($semester->id == $school_year->semester_id) ? 'selected' : '' }}>
                                    {{ $semester->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-black">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status">
                                <option value="">Select Status</option>
                                <option value="true" {{ ($school_year->is_active == true) ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="false" {{ ($school_year->is_active == false) ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
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
