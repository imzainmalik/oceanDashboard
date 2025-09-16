@extends('layouts.app')
@section('content')
    <div class="page-box py-4">
        <div class="card">
            <div class="card-header">
                Edit Family members
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('familyOwner.update_member', $user->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <label> Full name</label>
                            <input type="text" class="form-control" name="full_name" value="{{ $user->name }}"
                                required />
                        </div>
                        <div class="col-6">
                            <label> Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                required />
                        </div>

                        <div class="col-6">
                            <label> Password</label>
                            <input type="password" class="form-control" name="password" id="password" required />
                        </div>
                        <div class="col-6">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="cnfrm_password" id="confirm_password"
                                required />
                            <div class="invalid-feedback">Passwords do not match</div>
                        </div>
                        <div class="col-6">
                            <label> Display picture</label>
                            <input type="file" class="form-control" name="d_pic" id="d_pic" required /><br>
                            <p>Preview</p>
                            <img src="{{ asset('display_picture/' . $user->d_pic) }}" style="width:200px;"
                                class="img-thumb" />
                        </div>
                        <div class="col-6">
                            <label>Roles</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="2" @if ($user->role->id == 2) selected @endif>Family Owner
                                </option>
                                <option value="3" @if ($user->role->id == 3) selected @endif>Senior</option>
                                <option value="4" @if ($user->role->id == 4) selected @endif>Caregiver</option>
                                <option value="5" @if ($user->role->id == 5) selected @endif>Family Member
                                </option>
                            </select>
                        </div>
                        @if ($user->role->id == 3)
                            @php
                                $senoir = App\Models\Senior::where('user_id', $user->id)->first();
                            @endphp
                            <div class="container mt-4">
                                <!-- Senior-specific fields -->
                                <div id="senior-fields" class="row mt-3 @if ($user->role->id != 3) d-none @endif">
                                    <div class="col-6">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="" disabled>-- Select --</option>
                                            <option value="male" @if ($senoir->gender == 'male') selected @endif>Male
                                            </option>
                                            <option value="female" @if ($senoir->gender == 'female') selected @endif>Female
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="dob"
                                            value="{{ $senoir->dob }}" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Medical Condition</label>
                                        <input type="text" class="form-control" value="{{ $senoir->medical_condition }}"
                                            name="medical_condition" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Blood Type</label>
                                        <select class="form-control" name="blood_type" id="blood_type" required>
                                            <option disabled selected>Select Blood Type</option>
                                            <option value="A+" @if ($senoir->blood_type == 'A+') selected @endif>A
                                                positive</option>
                                            <option value="A-" @if ($senoir->blood_type == 'A-') selected @endif>A
                                                negative</option>
                                            <option value="B-" @if ($senoir->blood_type == 'B-') selected @endif>B
                                                negative</option>
                                            <option value="B+" @if ($senoir->blood_type == 'B+') selected @endif>B
                                                positive</option>
                                            <option value="O+" @if ($senoir->blood_type == 'O+') selected @endif>O
                                                positive</option>
                                            <option value="O-" @if ($senoir->blood_type == 'O-') selected @endif>O
                                                negative</option>
                                            <option value="AB-" @if ($senoir->blood_type == 'AB-') selected @endif>AB
                                                negative</option>
                                            <option value="AB+" @if ($senoir->blood_type == 'AB+') selected @endif>AB
                                                positive</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Primary Doctor</label>
                                        <input type="text" class="form-control" name="primary_doctor"
                                            value="{{ $senoir->primary_doctor }}" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" class="form-control" name="emergency_contact_name"
                                            value="{{ $senoir->emergency_contact_name }}" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>Emergency Contact Phone</label>
                                        <input type="text" class="form-control"
                                            value="{{ $senoir->emergency_contact_phone }}" name="emergency_contact_phone"
                                            required>
                                    </div>
                                    <div class="col-6 mb-2 form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="has_dementia"
                                            id="has_dementia" @if ($senoir->has_dementia == 1) checked @endif>
                                        <label class="form-check-label" for="has_dementia">Has Dementia</label>
                                    </div>
                                    <div class="col-6 mb-2 form-check">
                                        <input class="form-check-input" type="checkbox"value="1" name="has_alzheimer"
                                            id="has_alzheimer" @if ($senoir->has_alzheimer == 1) checked @endif>
                                        <label class="form-check-label" for="has_alzheimer">Has Alzheimer</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr>
                    {{-- @dd($user->permissions); --}}
                    <h4>Setup Permissions</h4>
                    <br>
                    <table class="table table-bordered table-striped align-middle text-center py-4">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">Features & Permission</th>
                                {{-- <th>Super Admin</th>
                                <th>Family Owner</th>
                                <th>Senior</th>
                                <th>Caregiver</th>
                                <th>Family Member</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">View Bills</td>
                                <td>
                                    <input class="form-check-input" name="permissions[]" value="view_bills"
                                        type="checkbox" @if ($user->permissions->contains('feature_name', 'view_bills')) checked @endif>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">Upload Documents</td>
                                <td>
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="upload_docs" @if ($user->permissions->contains('feature_name', 'upload_docs')) checked @endif>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">Manage Caregivers</td>
                                <td>
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="manage_caregivers" @if ($user->permissions->contains('feature_name', 'manage_caregivers')) checked @endif>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">View Reports</td>
                                <td>
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="view_reports" @if ($user->permissions->contains('feature_name', 'view_reports')) checked @endif>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <br>
                    <button class="btn btn-primary" type="submit" id="registerForm">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('role').addEventListener('change', function() {
            let seniorFields = document.getElementById('senior-fields');
            let inputs = seniorFields.querySelectorAll('input, select, textarea');

            if (this.value === "3") { // Senior selected
                seniorFields.classList.remove('d-none');
                inputs.forEach(input => input.setAttribute('required', true));
            } else {
                seniorFields.classList.add('d-none');
                inputs.forEach(input => input.removeAttribute('required'));
            }
        });

        $('#registerForm').click(function(e) {
            // e.preventDefault();
            const pass = document.getElementById('password');
            const confirmPass = document.getElementById('confirm_password');
            // console.log(pass.value, confirmPass.value);
            if (pass.value !== confirmPass.value) {
                e.preventDefault(); // stop form submission
                confirmPass.classList.add('is-invalid');
            } else {
                confirmPass.classList.remove('is-invalid');
            }
        });
    </script>
@endpush
