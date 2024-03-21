<?php

namespace App\Enums;

enum SurveyState: string
{
    use GetEnumsTrait;

    case CREATED = 'created';
    case INITIALIZED = 'initialized';
    case SENT = 'sent';
    case COMPLETED = 'completed';
}
