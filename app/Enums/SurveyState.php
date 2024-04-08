<?php

namespace App\Enums;

enum SurveyState: string
{
    use GetEnumsTrait;

    case Created = 'created';
    case Initialized = 'initialized';
    case Sent = 'sent';
    case Completed = 'completed';
}
