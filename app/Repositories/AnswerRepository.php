<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\SurveyItem;

class AnswerRepository
{
    public static function store(?array $data = null): ?Answer
    {
        $data = $data === null ? self::getDataFromRequest() : $data;

        $answer = new Answer();
        $answer->survey_item_id = $data['survey_item_id'];
        $answer->question_id = $data['question_id'];

        return self::assignAttributes($answer, $data);
    }

    public static function update(Answer $answer, ?array $data = null): ?Answer
    {
        $data = $data === null ? self::getDataFromRequest() : $data;

        return self::assignAttributes($answer, $data);
    }

    public static function storeOrUpdateMany($surveys): void
    {
        foreach ($surveys as $item) {
            if (isset($item['id'])) {
                self::update(Answer::find($item['id']), $item);
            } else {
                self::store($item);
            }
        }
    }

    /**
     * @return array
     */
    private static function getDataFromRequest(): array
    {
        return [
            'survey_item_id' => request()->input('survey_item_id'),
            'question_id' => request()->input('question_id'),
            'answer' => request()->input('answer'),
        ];
    }

    /**
     * @param Answer $answer
     * @param $value
     * @return Answer|null
     */
    private static function assignAttributes(Answer $answer, $value): ?Answer
    {
        if (is_array($value)) {
            $value = !empty($value) ? implode(',', $value) : null;
        }

        $answer->value = $value ?? null;
        $answer->save();

        return $answer->fresh();
    }

    public static function fillMany(SurveyItem $surveyItem, array $answers): SurveyItem
    {
        foreach ($answers as $row) {
            $answer = $surveyItem->answers->where('question_id', $row['question_id'])->first();

            if ($answer) {
                self::assignAttributes($answer, $row['answer']);
            }
        }

        return $surveyItem->fresh();
    }

    public static function checkForComplete(SurveyItem $surveyItem): SurveyItem
    {
        $error = false;

        foreach ($surveyItem->answers as $answer) {
            if ($answer->question->required && $answer->value === null) {
                $error = true;
            }
        }

        if (!$error) {
            $surveyItem->completed_at = now();
            $surveyItem->save();
        }

        return $surveyItem->fresh();
    }
}
