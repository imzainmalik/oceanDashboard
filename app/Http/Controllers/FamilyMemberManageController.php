<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Senior;
use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class FamilyMemberManageController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tenants = Tenant::where('owner_id', auth()->user()->id)
            ->whereHas('users', function ($q) {
                $q->whereIn('account_status', [0, 1]);
            })
            ->orderBy('id', 'DESC')
            ->get();
        // dd($tenants);
        // $tenants = Tenant::where('owner_id', auth()->user()->id)
        //     ->where('owner', 'account_status', '!=', 2)
        //     ->orderBy('id', 'DESC')
        //     ->get();

        if ($request->ajax()) {

            return DataTables::of($tenants)
                ->addColumn('user', function ($tenant) {
                    return '
                    <div class="user">
                        <img src="'.asset('display_picture/'.$tenant->users->d_pic).'" alt="">
                        <p>'.$tenant->users->name.'</p>
                    </div>
                ';
                })
                ->addColumn('email', function ($tenant) {
                    return $tenant->users->email;
                })
                ->addColumn('permissions', function ($tenant) {
                    $colors = colors();

                    $badges = '';
                    $permissions = $tenant->users->permissions ?? collect();
                    $total = $permissions->count();

                    if ($total > 0) {
                        foreach ($permissions->take(3) as $permission) {
                            $randomColor = $colors[array_rand($colors)];
                            $badges .= '<div class="badge me-1" style="background-color:'.$randomColor.';color:white;">'
                                     .$permission->feature_name.'</div>';
                        }

                        if ($total > 3) {
                            $badges .= '<button type="button" class="btn btn-link p-0 show-more-perms" 
                        data-bs-toggle="collapse" data-bs-target="#morePerms'.$tenant->id.'">
                        Show More
                    </button>';

                            $badges .= '<div class="collapse mt-2" id="morePerms'.$tenant->id.'">';
                            foreach ($permissions->slice(3) as $permission) {
                                $randomColor = $colors[array_rand($colors)];
                                $badges .= '<div class="badge me-1" style="background-color:'.$randomColor.';color:white;">'
                                         .$permission->feature_name.'</div>';
                            }
                            $badges .= '</div>';
                        }
                    }

                    return $badges;
                })
                ->addColumn('status', function ($tenant) {
                    $tasks = Task::where('assignee_id', $tenant->users->id)
                        ->where('status', 'completed')->get();

                    return '<span class="badge-table badge-green">'.$tasks->count().'</span>';
                })
                ->addColumn('acc_status', function ($tenant) {
                    if ($tenant->users->account_status == 0) {
                        return '<span class="badge-table badge-green">Active</span>';
                    } else {
                        return '<span class="badge-table badge-red">InActive</span>';
                    }
                })
                ->addColumn('action', function ($tenant) {
                    $actions = '
                    <div class="btn-group btnIconDetail">
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="first"><a class="dropdown-item" href="'.route('familyOwner.edit_member', $tenant->users->id).'">Edit</a></li>
                            <li class="last"><a class="dropdown-item" href="javascript:;" onclick="delete_member('.$tenant->users->id.')">Delete</a></li>';

                    if ($tenant->users->account_status == 0) {
                        $actions .= '<li class="last"><a class="dropdown-item" href="javascript:;" onclick="inactivate_member('.$tenant->users->id.')">Inactivate</a></li>';
                    } else {
                        $actions .= '<li class="last"><a class="dropdown-item" href="javascript:;" onclick="activate_member('.$tenant->users->id.')">Activate</a></li>';
                    }

                    $actions .= '</ul></div>';

                    return $actions;
                })
                ->rawColumns(['user', 'permissions', 'status', 'action', 'acc_status']) // HTML allow
                ->make(true);
        }

        return view('family_owner.family_member.index', compact('tenants'));
    }

    public function add_member()
    {
        return view('family_owner.family_member.create');
    }

    public function save_member(Request $request)
    {
        // dd($request->all());
        // return greetUser("zain"); // Output: Hello, Zain!

        if ($request->hasFile('d_pic')) {
            $attechment = $request->file('d_pic');
            $img_2 = time().$attechment->getClientOriginalName();
            $attechment->move(public_path('display_picture'), $img_2);
        } else {
            $img_2 = null;
        }

        $create_user = new User;
        $create_user->name = $request->full_name;
        $create_user->d_pic = $img_2;
        $create_user->email = $request->email;
        $create_user->role_id = $request->role;
        $create_user->password = Hash::make($request->cnfrm_password);
        $create_user->save();

        $create_tenant = new Tenant;
        $create_tenant->owner_id = auth()->user()->id;
        $create_tenant->owner_has_child = 1;
        $create_tenant->child_id = $create_user->id;
        $create_tenant->save();

        if ($request->role == 2) {
            // dd($request->all());
            $senior = new Senior;
            $senior->user_id = $create_user->id;
            $senior->family_owner_id = auth()->user()->id;
            $senior->blood_type = $request->blood_type;
            $senior->dob = $request->dob;
            $senior->gender = $request->gender;
            $senior->medical_condition = $request->medical_condition;
            $senior->primary_doctor = $request->primary_doctor;
            $senior->emergency_contact_name = $request->emergency_contact_name;
            $senior->emergency_contact_phone = $request->emergency_contact_phone;
            $senior->has_dementia = $request->has_dementia ?? 0;
            $senior->has_alzheimer = $request->has_alzheimer ?? 0;
            $senior->save();
            make_log(auth()->user()->id, auth()->user()->name, 'Created senior', ' '.auth()->user()->name.' Created '.$request->full_name.' as Senior ');
        }

        if ($request->permissions != null) {
            foreach ($request->permissions as $permission) {
                $permission_model = new Permission;
                $permission_model->user_id = $create_user->id;
                $permission_model->feature_name = $permission;
                $permission_model->save();
            }
        }

        make_log(auth()->user()->id, auth()->user()->name, 'Created Family member', ' '.auth()->user()->name.' Created '.$request->full_name.' as Member ');


        return redirect()->route('familyOwner.all_members')->with('success', 'Memeber created');
    }

    public function edit_member(Request $request, $id)
    {
        $user = User::findorfail($id);

        return view('family_owner.family_member.edit', compact('user'));
    }

    public function update_member(Request $request, $id)
    {

                // dd($request->all());

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'd_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'cnfrm_password' => 'nullable|min:8|confirmed',
            'role' => 'required|integer|in:1,2,3,4', // adjust role IDs
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|max:100',

            // Senior-specific fields
            'blood_type' => 'nullable|string|max:5',
            'dob' => 'nullable|date|before:today',
            'gender' => 'nullable|string|in:male,female,Other',
            'medical_condition' => 'nullable|string|max:255',
            'primary_doctor' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'has_dementia' => 'nullable|boolean',
            'has_alzheimer' => 'nullable|boolean',
        ]);
        $update_user = User::findorfail($id);

        if ($request->hasFile('d_pic')) {
            $attechment = $request->file('d_pic');
            $img_2 = time().$attechment->getClientOriginalName();
            $attechment->move(public_path('display_picture'), $img_2);
        } else {
            $img_2 = $update_user->d_pic;
        }
        $update_user->name = $request->full_name;

        if ($request->hasFile('d_pic')) {
            $update_user->d_pic = $img_2; // updated image if uploaded
        }

        if ($update_user->email != $request->email) {
            $update_user->email = $request->email;
        }

        // $update_user->role_id = $request->role;

        // update password only if provided
        if ($request->filled('cnfrm_password')) {
            $update_user->password = Hash::make($request->cnfrm_password);
        }

        $update_user->save();

        // 2. Update tenant (if needed)
        $update_tenant = Tenant::where('child_id', $update_user->id)->first();
        if ($update_tenant) {
            $update_tenant->owner_id = auth()->user()->id;
            $update_tenant->owner_has_child = 1;
            $update_tenant->child_id = $update_user->id;
            $update_tenant->save();
        }

        // 3. Update senior (only if role = Senior)
        if ($request->role == 3) {
            $senior = Senior::where('user_id', $update_user->id)->first();

            if (! $senior) {
                $senior = new Senior;
                $senior->user_id = $update_user->id;
                $senior->family_owner_id = auth()->user()->id;
            }

            $senior->blood_type = $request->blood_type;
            $senior->dob = $request->dob;
            $senior->gender = $request->gender;
            $senior->medical_condition = $request->medical_condition;
            $senior->primary_doctor = $request->primary_doctor;
            $senior->emergency_contact_name = $request->emergency_contact_name;
            $senior->emergency_contact_phone = $request->emergency_contact_phone;
            $senior->has_dementia = $request->has_dementia ?? 0;
            $senior->has_alzheimer = $request->has_alzheimer ?? 0;
            $senior->update();
            // dd($request->all());

            make_log(auth()->user()->id, auth()->user()->name, 'Updated senior', ' '.auth()->user()->name.' Updated '.$request->full_name.' as Senior ');
        }

        // 4. Update permissions (delete old → insert new)
        // dd($request->all());
        if ($request->permissions != null) {
            // dd($request->permissions);
            Permission::where('user_id', $update_user->id)->delete();
            foreach ($request->permissions as $permission) {
                $permission_model = new Permission;
                $permission_model->user_id = $update_user->id;
                $permission_model->feature_name = $permission;
                $permission_model->save();
            }
        }

        return redirect()->route('familyOwner.all_members')->with('success', 'Member updated successfuly');
    }

    public function delete_member($id)
    {
        // dd($id);
        $user = User::findorfail($id);
        User::where('id', $id)->update([
            'account_status' => 2,
        ]);

        make_log(auth()->user()->id, auth()->user()->name, 'Account Deleted', ' '.auth()->user()->name.' Deleted account of'.$user->name.'');

        return redirect()->route('familyOwner.all_members')->with('success', 'Member updated successfuly');
    }

    public function active_member(Request $request, $id)
    {

        $user = User::findorfail($id);

        User::where('id', $id)->update([
            'account_status' => $request->status,
        ]);

        if ($request->status == 0) {
            $status = 'Active';
        } else {
            $status = 'InActive';
        }
        make_log(auth()->user()->id, auth()->user()->name, 'Updated Account Status', ' '.auth()->user()->name.' Updated '.$user->name.' Account status as '.$status.' ');

        return redirect()->route('familyOwner.all_members')->with('success', 'Member updated successfuly');
    }
}
