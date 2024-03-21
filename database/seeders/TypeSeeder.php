<?php

namespace Database\Seeders;

use App\Enums\TypeCategory;
use App\Enums\TypeComponent;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $defaults = [
            [
                'component' => TypeComponent::DESCRIPTION,
                'category' => TypeCategory::OUTPUT,
                'label' => 'Description',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::IMAGE,
                'category' => TypeCategory::OUTPUT,
                'label' => 'Image',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::LIST,
                'category' => TypeCategory::OUTPUT,
                'label' => 'List',
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::TEXT,
                'category' => TypeCategory::INPUT,
                'label' => 'Text',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::NUMBER,
                'category' => TypeCategory::INPUT,
                'label' => 'Number',
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::DATE,
                'category' => TypeCategory::INPUT,
                'label' => 'Date',
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::RANGE,
                'category' => TypeCategory::INPUT,
                'label' => 'Range',
                'order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::RADIO_GROUP,
                'category' => TypeCategory::INPUT,
                'label' => 'Radio Group',
                'order' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::CHECKBOX_GROUP,
                'category' => TypeCategory::INPUT,
                'label' => 'Checkbox Group',
                'order' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::MULTIPLE_RADIO_GROUP,
                'category' => TypeCategory::INPUT,
                'label' => 'Multiple Radio Group',
                'order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Type::insert($defaults);
    }
}
