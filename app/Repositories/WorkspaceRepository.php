<?php

namespace App\Repositories;

use App\Models\Workspace;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkspaceRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Workspace>|Workspace[]
     */
    public static function getForUser(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Workspace::where('user_id', auth()->user()->id)
            ->get();
    }

    public static function store(): Workspace
    {
        $workspace = new Workspace();
        $workspace->user_id = auth()->user()->id;

        return self::assignAttributes($workspace);
    }

    public static function update(Workspace $workspace): Workspace
    {
        return self::assignAttributes($workspace);
    }

    public static function destroy(Workspace $workspace): void
    {
        $workspace->delete();
        self::deleteLogo($workspace);
    }

    private static function assignAttributes(Workspace $workspace): Workspace
    {
        $workspace->name = request()->input('name');
        self::storeLogo($workspace);

        $workspace->save();

        $groups = request()->input('groups');
        $groups = is_array($groups) ? array_filter($groups) : null;

        if (!empty($groups)) {
            $groups = collect(request()->input('groups'));
            $groups->transform(function ($item) use ($workspace) {
                $item['workspace_id'] = $workspace->id;
                return $item;
            });

            self::deleteGroups($workspace, $groups);
            GroupRepository::storeOrUpdateMany($groups);
        }

        return $workspace->fresh();
    }

    public static function storeLogo(Workspace $workspace): void
    {
        if (request()->has('logo')) {
            if (request()->input('logo') === null && $workspace->logo !== null) {
                self::deleteLogo($workspace);
                $workspace->logo = null;
            } else if (request()->hasFile('logo')) {
                $file = request()->file('logo');
                $fileName = Str::slug($workspace->name) . '-' . time() . '.' . $file->extension();
                $file->storeAs('/images/workspaces/logos', $fileName, 'public');
                $workspace->logo = $fileName;
            }
        }
    }

    public static function deleteLogo(Workspace $workspace): void
    {
        Storage::disk('public')->delete("/images/workspaces/logos/{$workspace->logo}");
    }

    public static function deleteGroups(Workspace $workspace, Collection $groups): void
    {
        if ($workspace->groups()->exists()) {
            $ids = $groups->whereNotNull('id')->pluck('id');
            $workspace->groups()->whereNotIn('id', $ids)->delete();
        }
    }
}
