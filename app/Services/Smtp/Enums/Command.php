<?php

namespace App\Services\Smtp\Enums;

enum Command: string
{
    case EHLO = 'EHLO';
    case HELO = 'HELO';
    case DATA = 'DATA';
    case QUIT = 'QUIT';
    case FROM_HEADER = 'MAIL FROM';
    case RECIPIENT_HEADER = 'RCPT TO';
}
