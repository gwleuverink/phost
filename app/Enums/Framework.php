<?php

namespace App\Enums;

enum Framework: string
{
    case Laravel = 'Laravel';
    case Symfony = 'Symfony';
    case Wordpress = 'Wordpress';
    case Yii = 'Yii';
    case Rails = 'Ruby on Rails';
}
