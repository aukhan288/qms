<?php

namespace App\Enums;

enum TemplateCategory: string
{

    case Internal_Documents  = 'internal documents';
    case Procedures  = 'procedures';
    case Procedures_2023  = 'procedures 2023';
    case Forms     = 'forms';
    case Forms_2023       = 'forms 2023';
    case External_Documents  = 'external documents';
    case Archive     = 'archive';
}
