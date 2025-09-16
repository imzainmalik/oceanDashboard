@extends('layouts.app')
@section('content')
    <div class="page-box py-4">
        <div class="card">
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
                                <option value="2">Family Owner</option>
                                <option value="3">Senior</option>
                                <option value="4">Caregiver</option>
                                <option value="5">Family Member</option>
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
                                        <option value="A positive">A positive</option>
                                        <option value="A negative">A negative</option>
                                        <option value="B negative">B negative</option>
                                        <option value="B positive">B positive</option>
                                        <option value="O positive">O positive</option>
                                        <option value="O negative">O negative</option>
                                        <option value="AB negative">AB negative</option>
                                        <option value="AB positive">AB positive</option>
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
                                <td><input class="form-check-input" name="permissons[]" value="view_bills"
                                        type="checkbox">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">Upload Documents</td>
                                <td><input class="form-check-input" type="checkbox" value="upload_docs"
                                        name="permissons[]">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">Manage Caregivers</td>
                                <td><input class="form-check-input" type="checkbox" value="manage_caregivers"
                                        name="permissons[]"></td>
                            </tr>
                            <tr>
                                <td class="text-start">View Reports</td>
                                <td><input class="form-check-input" type="checkbox" value="view_reports"
                                        name="permissons[]"></td>
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
