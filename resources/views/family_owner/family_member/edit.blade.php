@extends('layouts.app')
@section('content')
    <div class="page-box py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Edit Family members
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('familyOwner.update_member', $user->id) }}"
                    enctype="multipart/form-data">
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
                            <input type="password" class="form-control" name="password" id="password" />
                        </div>
                        <div class="col-6">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="cnfrm_password" id="confirm_password" />
                            <div class="invalid-feedback">Passwords do not match</div>
                        </div>
                        <div class="col-6">
                            <label> Display picture</label>
                            <input type="file" class="form-control" name="d_pic" id="d_pic" /><br>
                            <p>Preview</p>
                            <img src="{{ asset('display_picture/' . $user->d_pic) }}" style="width:200px;"
                                class="img-thumb" />
                        </div>
                        <div class="col-6">
                            <label>Roles</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="2" @if ($user->role->id == 4) selected @endif>Family Owner
                                </option>
                                <option value="3" @if ($user->role->id == 2) selected @endif>Senior</option>
                                <option value="4" @if ($user->role->id == 5) selected @endif>Caregiver</option>
                                <option value="5" @if ($user->role->id == 3) selected @endif>Family Member
                                </option>
                            </select>
                        </div>
                        @if ($user->role->id == 2)
                            @php
                                $senoir = App\Models\Senior::where('user_id', $user->id)->first();
                            @endphp
                            <div class="container mt-4">
                                <!-- Senior-specific fields -->
                                <div id="senior-fields" class="row mt-3 @if ($user->role->id != 2) d-none @endif">
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
                    <br>
                    <div class="container mt-4">
                        <h3 class="mb-4">⚙️ Setup Permissions</h3>

                        {{-- <div class="list-group">

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
                                        id="upload_docs" value="upload_docs">
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

                        </div> --}}
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
                                    @php
                                        $modules = [
                                            'Bills' => 'bills',
                                            'Documents' => 'documents',
                                            'Caregivers' => 'caregivers',
                                            'Reports' => 'reports',
                                            'Daily Tasks and Care logs' => 'tasks',
                                            'Family Members' => 'members',
                                            // 'Subscription' => 'subscription',
                                            'Notes & Wellness' => 'notes',
                                            'Meetings' => 'meetings',
                                            'Voting Pools' => 'pools',
                                            'Seniors' => 'seniors',
                                            // 'Caregiver Special' => 'caregiver',
                                            // 'Admin' => 'admin',
                                        ];
                                    @endphp

                                    @foreach ($modules as $label => $id)
                                        <li class="nav-item">
                                            <a class="nav-link @if ($loop->first) active @endif"
                                                id="{{ $id }}-tab" data-bs-toggle="tab"
                                                href="#{{ $id }}" role="tab">{{ $label }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="permissionTabsContent">

                                    {{-- Bills --}}
                                    <div class="tab-pane fade show active" id="bills" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'bills'])
                                        @include('components.permissions', ['feature' => 'bill_payments'])
                                        {{-- @include('components.permissions', ['feature' => 'contributions']) --}}
                                        {{-- @include('components.permissions', ['feature' => 'reimbursements']) --}}
                                        <div class="mt-3"><span class="badge bg-info">shortfall_tracking_show</span>
                                        </div>
                                    </div>

                                    {{-- Documents --}}
                                    <div class="tab-pane fade" id="documents" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'documents'])
                                        @include('components.permissions', ['feature' => 'medical_docs'])
                                        @include('components.permissions', ['feature' => 'insurance_docs'])
                                        @include('components.permissions', ['feature' => 'emergency_docs'])
                                    </div>

                                    {{-- Caregivers --}}
                                    <div class="tab-pane fade" id="caregivers" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'caregivers'])
                                        <div class="mt-3">
                                            <span class="badge bg-info">User can only manage details of care givers, can't
                                                Assign different role</span>
                                        </div>
                                    </div>

                                    {{-- Reports --}}
                                    <div class="tab-pane fade" id="reports" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'reports'])
                                    </div>

                                    {{-- Tasks & Requests --}}
                                    <div class="tab-pane fade" id="tasks" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'tasks'])
                                        {{-- @include('components.permissions', ['feature' => 'requests']) --}}
                                    </div>

                                    {{-- Family Members --}}
                                    <div class="tab-pane fade" id="members" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'members'])
                                        <div class="mt-3">
                                            <span class="badge bg-info">permissions_assign</span>
                                            <span class="badge bg-info">permissions_update</span>
                                            <span class="badge bg-info">permissions_delete</span>
                                            <span class="badge bg-info">permissions_show</span>
                                        </div>
                                    </div>

                                    {{-- Subscription --}}
                                    {{-- <div class="tab-pane fade" id="subscription" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'subscription'])
                                        @include('components.permissions', [
                                            'feature' => 'payment_methods',
                                        ])
                                    </div> --}}

                                    {{-- Notes & Wellness --}}
                                    <div class="tab-pane fade" id="notes" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'family_notes'])
                                        {{-- @include('components.permissions', [
                                            'feature' => 'wellness_checkins',
                                        ]) --}}
                                        {{-- @include('components.permissions', [
                                            'feature' => 'voice_journals',
                                        ]) --}}
                                    </div>

                                    {{-- Meetings & Events --}}
                                    <div class="tab-pane fade" id="meetings" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'meetings'])
                                        {{-- @include('components.permissions', ['feature' => 'events']) --}}
                                        {{-- @include('components.permissions', ['feature' => 'vacations']) --}}
                                    </div>

                                    {{-- Voting Pools --}}
                                    <div class="tab-pane fade" id="pools" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'pools'])
                                        <div class="mt-3">
                                            <span class="badge bg-info">votes_cast</span>
                                            <span class="badge bg-info">votes_view</span>
                                        </div>
                                    </div>

                                    {{-- Seniors --}}
                                    <div class="tab-pane fade" id="seniors" role="tabpanel">
                                        @include('components.permissions', ['feature' => 'daily_updates'])
                                        <div class="mt-3">
                                            <span class="badge bg-info">notifications_update</span>
                                            <span class="badge bg-info">notifications_show</span>
                                            <span class="badge bg-info">profile_update</span>
                                            <span class="badge bg-info">profile_show</span>
                                        </div>
                                    </div>

                                    {{-- Caregiver Special --}}
                                    <div class="tab-pane fade" id="caregiver" role="tabpanel">
                                        <div class="mt-3">
                                            <span class="badge bg-info">activity_timeline_show</span>
                                            <span class="badge bg-info">emergency_protocol_show</span>
                                        </div>
                                    </div>

                                    {{-- Admin --}}
                                    {{-- <div class="tab-pane fade" id="admin" role="tabpanel">
                                        <div class="mt-3">
                                            <span class="badge bg-danger">super_admin_only</span>
                                        </div>
                                    </div> --}}

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
