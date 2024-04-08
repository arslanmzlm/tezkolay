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
                'component' => TypeComponent::Description,
                'category' => TypeCategory::Output,
                'label' => 'Description',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::Image,
                'category' => TypeCategory::Output,
                'label' => 'Image',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::List,
                'category' => TypeCategory::Output,
                'label' => 'List',
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::Text,
                'category' => TypeCategory::Input,
                'label' => 'Text',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::Number,
                'category' => TypeCategory::Input,
                'label' => 'Number',
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::Date,
                'category' => TypeCategory::Input,
                'label' => 'Date',
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::Range,
                'category' => TypeCategory::Input,
                'label' => 'Range',
                'order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::RadioGroup,
                'category' => TypeCategory::Input,
                'label' => 'Radio Group',
                'order' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::CheckboxGroup,
                'category' => TypeCategory::Input,
                'label' => 'Checkbox Group',
                'order' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'component' => TypeComponent::MultipleRadioGroup,
                'category' => TypeCategory::Input,
                'label' => 'Multiple Radio Group',
                'order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Type::insert($defaults);
    }
}
