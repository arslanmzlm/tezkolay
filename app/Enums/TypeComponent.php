<?php

namespace App\Enums;

enum TypeComponent: string
{
    use GetEnumsTrait;

    case Text = "Text";
    case Number = "Number";
    case RadioGroup = "RadioGroup";
    case CheckboxGroup = "CheckboxGroup";
    case Date = "Date";
    case MultipleRadioGroup = "MultipleRadioGroup";
    case Range = "Range";

    case Description = "Description";
    case Image = "Image";
    case List = "List";

    public static function inputs(): array
    {
        return [
            self::Text,
            self::Number,
            self::RadioGroup,
            self::CheckboxGroup,
            self::Date,
            self::MultipleRadioGroup,
            self::Range,
        ];
    }

    public static function outputs(): array
    {
        return [
            self::Description,
            self::Image,
            self::List,
        ];
    }

    public static function hasValues(): array
    {
        return [
            self::RadioGroup,
            self::CheckboxGroup,
            self::MultipleRadioGroup,
            self::List,
        ];
    }

    public static function hasRelation(): array
    {
        return [
            self::MultipleRadioGroup,
        ];
    }

    public static function hasMultipleAnswer(): array
    {
        return [
            self::CheckboxGroup,
        ];
    }
}
