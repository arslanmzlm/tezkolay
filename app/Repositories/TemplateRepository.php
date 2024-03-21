<?php

namespace App\Repositories;

use App\Models\Template;
use Illuminate\Support\Collection;

class TemplateRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Template>|Template[]
     */
    public static function getForUser(): \Illuminate\Database\Eloquent\Collection|array
    {
        $userId = auth()->user()->id;

        return Template::where('is_private', false)
            ->orWhere(function ($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('is_private', true);
            })
            ->get();
    }

    /**
     * Store template data.
     *
     * @return Template
     */
    public static function store(): Template
    {
        $template = new Template();
        $template->created_by = request()->user()->id;

        return self::assignAttributes($template);
    }

    /**
     * Update template data.
     *
     * @param Template $template
     * @return Template
     */
    public static function update(Template $template): Template
    {
        return self::assignAttributes($template);
    }

    private static function assignAttributes(Template $template): Template
    {
        $template->name = request()->input('name');
        $template->description = request()->input('description');
        $template->is_private = request()->boolean('is_private');
        $template->save();

        $questions = request()->all()['questions'] ?? null;

        if (!empty($questions)) {
            $questions = collect($questions);
            $questions->transform(function ($item) use ($template) {
                $item['template_id'] = $template->id;
                return $item;
            });

            self::deleteQuestions($template, $questions);
            QuestionRepository::storeOrUpdateMany($questions);
        }

        return $template->fresh();
    }

    private static function deleteQuestions(Template $template, Collection $questions): void
    {
        if ($template->questions()->exists()) {
            $ids = $questions->whereNotNull('id')->pluck('id');
            $template->questions()->whereNotIn('id', $ids)->delete();
        }
    }
}
