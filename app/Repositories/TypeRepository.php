<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;

class TypeRepository
{
    /**
     * Get question types.
     *
     * @return Collection
     */
    public static function getForTemplate(): Collection
    {
        return Type::query()
            ->where('user_id', request()->user()->id)
            ->orWhereNull('user_id')
            ->orderByRaw('-`order` desc')
            ->get();
    }

    /**
     * Store question type.
     *
     * @return Type
     * @throws \Exception
     */
    public static function store(): Type
    {
        $main_type = Type::find(request()->input('main_type_id'));

        $type = new Type();
        $type->user_id = request()->user()->id;
        $type->component = $main_type->component;
        $type->category = $main_type->category;
        $type->main_type_id = $main_type->main_type_id ?? $main_type->id;

        return self::assignAttributes($type);
    }

    /**
     * Update question type.
     *
     * @param Type $type
     * @return Type
     */
    public static function update(Type $type): Type
    {
        return self::assignAttributes($type);
    }

    /**
     * Delete question type and update related questions.
     *
     * @param Type $type
     * @return boolean
     */
    public static function delete(Type $type): bool
    {
        Question::where('type_id', $type->id)
            ->update([
                'type_id' => $type->main_type_id
            ]);

        return (bool)$type->delete();
    }

    private static function assignAttributes(Type $type): Type
    {
        $type->label = request()->input('label');
        $type->description = request()->input('description');
        $type->required = request()->boolean('required');
        $type->value = is_string(request()->input('value')) ? request()->input('value') : null;
        $type->values = is_array(request()->input('values')) && !empty(array_filter(request()->input('values'))) ? array_filter(request()->input('values')) : null;
        $type->options = is_array(request()->input('options')) && !empty(array_filter(request()->input('options'))) ? array_filter(request()->input('options')) : null;

        $type->save();

        return $type->fresh();
    }
}
