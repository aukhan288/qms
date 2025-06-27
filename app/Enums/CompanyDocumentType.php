<?php

namespace App\Enums;

enum CompanyDocumentType: string
{
    case Insurance = 'Insurance';
    case Warranty = 'Warranty';
    case ComplianceCertificate = 'Compliance Certificate';
    case Other = 'Other';
}
