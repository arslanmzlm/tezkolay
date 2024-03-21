<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateGroupSurveysRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;
use App\Repositories\TemplateRepository;
use Inertia\Inertia;

class GroupSurveyController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return Inertia::render('App/Group/Surveys', [
            'group' => $group->append(['workspace_name', 'user_id'])->load('surveys'),
            'templates' => TemplateRepository::getForUser(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupSurveysRequest $request, Group $group)
    {
        try {
            GroupRepository::update($group);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', trans('messages.error')];
        }

        return to_route('app.workspace.list')->with('toast', $toast);
    }
}
