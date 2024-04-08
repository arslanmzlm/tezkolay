<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateGroupPatientsRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Inertia\Inertia;

class GroupPatientController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return Inertia::render('App/Group/Patients', [
            'group' => $group->append(['workspace_name', 'user_id'])->load('patients')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupPatientsRequest $request, Group $group)
    {
        try {
            GroupRepository::update($group);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages.error')];
        }

        return to_route('app.workspace.list')->with('toast', $toast);
    }
}
