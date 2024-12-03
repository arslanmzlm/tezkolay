<?php

namespace App\Enums;

enum SurveyItemState: string
{
    use GetEnumsTrait;

    case Created = 'created';
    case Sent = 'sent';
    case Completed = 'completed';
}
