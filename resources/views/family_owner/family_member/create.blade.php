@extends('layouts.app')
@section('content')
    <div class="page-box py-4">
        <div class="card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-header">
                Create Family members
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('familyOwner.save_member') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <label> Full name</label>
                            <input type="text" class="form-control" name="full_name" required />
                        </div>
                        <div class="col-6">
                            <label> Email</label>
                            <input type="email" class="form-control" name="email" required />
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
                            <input type="file" class="form-control" name="d_pic" id="d_pic" required />
                        </div>

                        <div class="col-6">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option value="">-- Select --</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Roles</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="4">Family Owner</option>
                                <option value="2">Senior</option>
                                <option value="5">Caregiver</option>
                                <option value="3">Family Member</option>
                            </select>
                        </div>


                        <div class="container mt-4">
                            <!-- Senior-specific fields -->
                            <div id="senior-fields" class="row mt-3 d-none">
                                <div class="col-6 mb-2">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label>Medical Condition</label>
                                    <input type="text" class="form-control" name="medical_condition" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label>Blood Type</label>
                                    <select class="form-control" name="blood_type" id="blood_type" required>
                                        <option disabled selected>Select Blood Type</option>
                                        <option value="A+">A
                                            positive</option>
                                        <option value="A-">A
                                            negative</option>
                                        <option value="B-">B
                                            negative</option>
                                        <option value="B+">B
                                            positive</option>
                                        <option value="O+">O
                                            positive</option>
                                        <option value="O-">O
                                            negative</option>
                                        <option value="AB-">AB
                                            negative</option>
                                        <option value="AB+">AB
                                            positive</option>
                                    </select>
                                </div>
                                <div class="col-6 mb-2">
                                    <label>Primary Doctor</label>
                                    <input type="text" class="form-control" name="primary_doctor" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label>Emergency Contact Name</label>
                                    <input type="text" class="form-control" name="emergency_contact_name" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label>Emergency Contact Phone</label>
                                    <input type="text" class="form-control" name="emergency_contact_phone" required>
                                </div>
                                <div class="col-6 mb-2 form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="has_dementia"
                                        id="has_dementia">
                                    <label class="form-check-label" for="has_dementia">Has Dementia</label>
                                </div>
                                <div class="col-6 mb-2 form-check">
                                    <input class="form-check-input" type="checkbox"value="1" name="has_alzheimer"
                                        id="has_alzheimer">
                                    <label class="form-check-label" for="has_alzheimer">Has Alzheimer</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="container mt-4">
                        <h3 class="mb-4">⚙️ Setup Permissions</h3>

                        <div class="list-group">

                            <!-- View Bills -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>View Bills</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="permissions[]" type="checkbox"
                                        value="view_bills">
                                    <label class="form-check-label" for="view_bills"></label>
                                </div>
                            </div>

                            <!-- Upload Documents -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Upload Documents</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        id="upload_docs">
                                    <label class="form-check-label" for="upload_docs"></label>
                                </div>
                            </div>

                            <!-- Manage Caregivers -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Manage Caregivers</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="manage_caregivers"
                                        name="permissions[]" value="manage_caregivers">
                                    <label class="form-check-label" for="manage_caregivers"></label>
                                </div>
                            </div>

                            <!-- View Reports -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>View Reports</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        id="permViewReports"name="permissions[]" value="view_reports">
                                    <label class="form-check-label" for="view_reports"></label>
                                </div>
                            </div>

                            <!-- Manage Tasks -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Manage Tasks</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="manage_tasks"
                                        name="permissions[]" value="manage_tasks">
                                    <label class="form-check-label" for="manage_tasks"></label>
                                </div>
                            </div>

                            <!-- Manage Family Members -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Manage Family Members</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="manage_family_members"
                                        name="permissions[]" value="manage_family_members">
                                    <label class="form-check-label" for="manage_family_members"></label>
                                </div>
                            </div>

                            <!-- Manage Subscription -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Manage Subscription</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="manage_subscription"
                                        name="permissions[]" value="manage_subscription">
                                    <label class="form-check-label" for="manage_subscription"></label>
                                </div>
                            </div>

                            <!-- Emergency Documents -->
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Emergency Documents</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emergency_doc"
                                        name="permissions[]" value="emergency_doc">
                                    <label class="form-check-label" for="emergency_doc"></label>
                                </div>
                            </div>

                        </div>
                    </div>

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

            if (this.value === "2") { // Senior selected
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
