<?php

namespace App\Services\Smtp\Enums;

enum Reply: string
{
    case Ready = '220';
    case Goodbye = '221';
    case Okay = '250';
    case StartTransfer = '354';
    case CommandNotImplemented = '504';
}
