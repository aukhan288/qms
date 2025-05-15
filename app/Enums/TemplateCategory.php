<?php

namespace App\Enums;

enum TemplateCategory: string
{
    case Newsletters = 'newsletters';
    case Procedures  = 'procedures';
    case Records     = 'records';
    case Forms       = 'forms';
}
