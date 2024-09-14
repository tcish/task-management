<?php

namespace App\Http\Controllers;

use App\Models\TaskPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        // Define the validation rules
        $rules = [
            'permit_to' => 'required|integer',
            'permission' => 'required|array',
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $params = $request->all();
        $data = [
            'permit_to' => $params['permit_to'],
            'can_assign' => 0,
            'can_create' => 0,
        ];

        // Iterate over the permissions in $params['permission']
        foreach ($params['permission'] as $permission) {
            if ($permission === 'can_assign') {
                $data['can_assign'] = 1;
            }
            if ($permission === 'can_create') {
                $data['can_create'] = 1;
            }
        }

        $permission = TaskPermission::where('permit_to', $params['permit_to'])->first();
        if ($permission) {
            $permission->update($data);

            Session::flash('success', 'Permission updated successfully!');
        } else {
            TaskPermission::create($data);

            Session::flash('success', 'Permission given successfully!');
        }


        return redirect()->route('tasks.index');
    }

    function getPermissionByUserId($id) {
        $permission = TaskPermission::where('permit_to', $id)->first();

        return response()->json(["status" => true, "permission" => $permission]);
    }
}
