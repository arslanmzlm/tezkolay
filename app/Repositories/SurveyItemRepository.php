<?php

namespace App\Repositories;

use App\Enums\TypeCategory;
use App\Models\Answer;
use App\Models\Patient;
use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyItem;

class SurveyItemRepository
{
    public static function get(Survey $survey, Patient $patient): SurveyItem
    {
        $surveyItem = SurveyItem::where([
            'survey_id' => $survey->id,
            'patient_id' => $patient->id
        ])->first();

        if (!$surveyItem) {
            $surveyItem = new SurveyItem();
            $surveyItem->survey_id = $survey->id;
            $surveyItem->patient_id = $patient->id;
            $surveyItem->save();

            $questions = collect();
            $now = now();

            $survey->questions()
                ->whereRelation('type', 'category', TypeCategory::Input)
                ->each(function (Question $question) use ($surveyItem, $questions, $now) {
                    $questions->add([
                        'survey_item_id' => $surveyItem->id,
                        'question_id' => $question->id,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                });

            Answer::insert($questions->toArray());
        }

        return $surveyItem->fresh();
    }

    public static function getViewDataForFill(Survey $survey, Patient $patient): array
    {
        $surveyItem = self::get($survey, $patient);

        $surveyItem->survey->questions->transform(function (Question $question) use ($surveyItem) {
            if ($question->isInput()) {
                $answer = $surveyItem->answers->where('question_id', $question->id)->first();
                if ($question->hasMultipleAnswer() && !empty($answer->value)) {
                    $question->value = explode(',', $answer->value);
                } else {
                    $question->value = $answer->value;
                }
            }

            return $question;
        });

        return [
            'survey' => $surveyItem->survey,
            'surveyItem' => $surveyItem,
        ];
    }

    public static function update(SurveyItem $surveyItem, ?array $data = null): SurveyItem
    {
        $data = $data ?: self::getDataFromRequest();

        if (!empty($data['answers'])) {
            self::fill($surveyItem, $data['answers']);
        }

        return $surveyItem->fresh();
    }

    private static function getDataFromRequest(): array
    {
        return [
            'answers' => request()->input('answers'),
        ];
    }

    private static function fill(SurveyItem $surveyItem, array $answers): void
    {
        // TODO: Check answers

        AnswerRepository::fillMany($surveyItem, $answers);

        AnswerRepository::checkForComplete($surveyItem);
    }
}
