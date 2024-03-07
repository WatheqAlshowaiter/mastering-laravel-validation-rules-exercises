<?php

declare(strict_types=1);

namespace App\Models;

class SkillPosting
{
    /**
     * These are the only valid categories for users to pick from
     */
    public const VALID_CATEGORIES = [
        'lawn',
        'tutoring',
        'moving',
        'office',
    ];
}
