<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title text-white">
                    @if (Route::is('admin.user.information.faculty.index'))
                        Add Faculty Member
                    @endif
                </h5>
            </div>
            <form action="{{ route('admin.user.information.faculty.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="first_name" class="form-label fw-bold text-black">First
                                Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="{{ old('first_name') }}">
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="last_name" class="form-label fw-bold text-black">Last
                                Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                value="{{ old('last_name') }}">
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="email" class="form-label fw-bold text-black">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="phone" class="form-label fw-bold text-black">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="department_id" class="form-label fw-bold text-black">Department</label>
                            <select class="form-select" id="department_id" name="department_id">
                                <option selected disabled>Select Department</option>
                                @foreach ($departments as $department)
                                    <option
                                        value="{{ $department->id }}"@if ($department->id == old('department_id')) selected @endif>
                                        {{ $department->department_name }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="password" class="form-label fw-bold text-black">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label fw-bold text-black">Confirm
                                Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit-e" class="btn btn-maroon">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
