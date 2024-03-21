<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateGroupPatientsRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;
use App\Repositories\WorkspaceRepository;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('App/Dashboard', [
            'workspaces' => WorkspaceRepository::getForUser()->load('groups'),
        ]);
    }
}
