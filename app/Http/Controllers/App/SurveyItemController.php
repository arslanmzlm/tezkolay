<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateSurveyItemRequest;
use App\Models\Patient;
use App\Models\Survey;
use App\Models\SurveyItem;
use App\Repositories\SurveyItemRepository;
use Inertia\Inertia;

class SurveyItemController extends Controller
{
    public function show(Survey $survey, Patient $patient)
    {
        $viewData = SurveyItemRepository::getViewDataForFill($survey, $patient);

        return Inertia::render('App/Survey/Fill', $viewData);
    }

    public function update(UpdateSurveyItemRequest $request, SurveyItem $surveyItem)
    {
        try {
            $surveyItem->filled_by_user = true;
            SurveyItemRepository::update($surveyItem);

            $toast = trans('messages.success');
        } catch (\Error|\Exception $exception) {
            $toast = ['type' => 'error', 'message' => trans('messages.error')];
        }

        return to_route('app.survey.list')->with('toast', $toast);
    }
}
