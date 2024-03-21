<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreTemplateRequest;
use App\Http\Requests\User\UpdateTemplateRequest;
use App\Models\Template;
use App\Repositories\TemplateRepository;
use App\Repositories\TypeRepository;
use Inertia\Inertia;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Template/List', [
            'templates' => TemplateRepository::getForUser()->load('questions'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('App/Template/Create', [
            'types' => TypeRepository::getForTemplate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTemplateRequest $request)
    {
        try {
            TemplateRepository::store();

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', trans('messages.error')];
        }

        return to_route('app.template.list')->with('toast', $toast);
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        return Inertia::render('App/Template/Show', [
            'template' => $template->load('questions'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        return Inertia::render('App/Template/Edit', [
            'types' => TypeRepository::getForTemplate(),
            'template' => $template->load('questions'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateRequest $request, Template $template)
    {
        try {
            TemplateRepository::update($template);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', trans('messages.error')];
        }

        return to_route('app.template.list')->with('toast', $toast);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        try {
            $template->delete();

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', trans('messages.error')];
        }

        return Inertia::location(to_route('app.template.list')->with('toast', $toast));
    }
}
