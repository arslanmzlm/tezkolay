<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreWorkspaceRequest;
use App\Http\Requests\User\UpdateWorkspaceRequest;
use App\Models\Workspace;
use App\Repositories\WorkspaceRepository;
use Inertia\Inertia;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Workspace/List', [
            'workspaces' => WorkspaceRepository::getForUser()->load('groups'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('App/Workspace/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkspaceRequest $request)
    {
        try {
            WorkspaceRepository::store();

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages.error')];
        }

        return to_route('app.workspace.list')->with('toast', $toast);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace)
    {
        return Inertia::render('App/Workspace/Edit', [
            'workspace' => $workspace->load('groups'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        try {
            WorkspaceRepository::update($workspace);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages.error')];
        }

        return to_route('app.workspace.list')->with('toast', $toast);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace)
    {
        try {
            WorkspaceRepository::destroy($workspace);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages.error')];
        }

        return Inertia::location(to_route('app.workspace.list')->with('toast', $toast));
    }
}
