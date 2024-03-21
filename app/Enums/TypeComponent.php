<?php

namespace App\Enums;

enum TypeComponent: string
{
    use GetEnumsTrait;

    const TEXT = "Text";
    const NUMBER = "Number";
    const RADIO_GROUP = "RadioGroup";
    const CHECKBOX_GROUP = "CheckboxGroup";
    const DATE = "Date";
    const MULTIPLE_RADIO_GROUP = "MultipleRadioGroup";
    const RANGE = "Range";

    const DESCRIPTION = "Description";
    const IMAGE = "Image";
    const LIST = "List";

    public static function inputs(): array
    {
        return [
            self::TEXT,
            self::NUMBER,
            self::RADIO_GROUP,
            self::CHECKBOX_GROUP,
            self::DATE,
            self::MULTIPLE_RADIO_GROUP,
            self::RANGE,
        ];
    }

    public static function outputs(): array
    {
        return [
            self::DESCRIPTION,
            self::IMAGE,
            self::LIST,
        ];
    }

    public static function hasValues(): array
    {
        return [
            self::RADIO_GROUP,
            self::CHECKBOX_GROUP,
            self::MULTIPLE_RADIO_GROUP,
            self::LIST,
        ];
    }

    public static function hasRelation(): array
    {
        return [
            self::MULTIPLE_RADIO_GROUP,
        ];
    }
}
