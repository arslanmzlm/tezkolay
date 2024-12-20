<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Patient;
use App\Models\Survey;
use App\Repositories\GroupRepository;
use App\Repositories\SurveyRepository;
use Inertia\Inertia;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = GroupRepository::getForUser()
            ->load(['surveys', 'patients'])
            ->transform(function (Group $group) {
                $group->surveys->append(['completed_count', 'completed_percent']);

                return $group;
            });

        return Inertia::render('App/Survey/List', [
            'groups' => $groups,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        $patients = $survey->group
            ->patients()
            ->paginate(request()->query('per_page', 10))
            ->through(function (Patient $patient) use ($survey) {
                $patient['survey_item'] = $survey->items->where('patient_id', $patient->id)->first();
                return $patient;
            });

        return Inertia::render('App/Survey/Show', [
            'survey' => $survey,
            'patients' => $patients
        ]);
    }

    public function initialize(Survey $survey)
    {
        try {
            if ($survey->isCanInitialize()) {
                SurveyRepository::init($survey);

                $toast = trans('messages.success');
            } else {
                $toast = ['type' => 'error', 'message' => trans('messages.survey_invalid_for_initialize')];
            }
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages . error')];
        }

        return Inertia::location(to_route('app.survey.list', status: 303)->with('toast', $toast));
    }
}
