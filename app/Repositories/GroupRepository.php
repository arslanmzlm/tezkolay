<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GroupRepository
{
    public static function store(?array $data = null): Group
    {
        $data = $data ?: self::getDataFromRequest();

        $group = new Group();
        $group->workspace_id = $data['workspace_id'];

        return self::assignAttributes($group, $data);
    }

    public static function update(Group $group, ?array $data = null): Group
    {
        $data = $data ?: self::getDataFromRequest();

        return self::assignAttributes($group, $data);
    }

    private static function getDataFromRequest(): array
    {
        return [
            'name' => request()->input('name'),
            'size' => request()->input('size'),
            'logo' => request()->input('logo'),
            'patients' => request()->input('patients'),
            'surveys' => request()->input('surveys'),
        ];
    }

    private static function storeLogo(Group $group, array $data): void
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $file = $data['logo'];
            $fileName = Str::slug($group->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storeAs('/images/groups/logos', $fileName, 'public');
            $group->logo = $fileName;
        }
    }

    private static function assignAttributes(Group $group, array $data): Group
    {
        $group->name = $data['name'] ?? $group->name;
        $group->size = intval($data['size'] ?? $group->size);
        self::storeLogo($group, $data);

        $group->save();

        if (isset($data['patients'])) {
            $patients = collect($data['patients'])->whereNotNull('phone');

            if ($patients->isNotEmpty()) {
                $patients->transform(function ($item) use ($group) {
                    $item['group_id'] = $group->id;
                    return $item;
                });

                self::deleteOldPatients($group, $patients);
                PatientRepository::storeOrUpdateMany($patients);
            }
        }


        if (isset($data['surveys'])) {
            $surveys = collect($data['surveys']);

            if ($surveys->isNotEmpty()) {
                $surveys->transform(function ($item) use ($group) {
                    $item['group_id'] = $group->id;
                    return $item;
                });

                self::deleteOldSurveys($group, $surveys);
                SurveyRepository::storeOrUpdateMany($surveys);
            }
        }

        return $group->fresh();
    }

    public static function storeOrUpdateMany(Collection $groups): void
    {
        foreach ($groups as $item) {
            if (isset($item['id'])) {
                self::update(Group::find($item['id']), $item);
            } else {
                self::store($item);
            }
        }
    }

    public static function deleteOldPatients(Group $group, Collection $patients): void
    {
        if ($group->patients()->exists()) {
            $ids = $patients->whereNotNull('id')->pluck('id');
            $group->patients()->whereNotIn('id', $ids)->delete();
        }
    }

    public static function deleteOldSurveys(Group $group, Collection $surveys): void
    {
        if ($group->surveys()->exists()) {
            $ids = $surveys->whereNotNull('id')->pluck('id');
            $group->surveys()->whereNotIn('id', $ids)->delete();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Group>|Group[]
     */
    public static function getForUser(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Group::whereRelation('workspace', 'user_id', auth()->user()->id)
            ->get();
    }
}
