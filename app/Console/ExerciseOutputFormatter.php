<?php

declare(strict_types=1);

namespace App\Console;

class ExerciseOutputFormatter
{
    protected $requirements;

    public function __construct(array $requirements)
    {
        $this->requirements = $requirements;
    }

    public function getHeader(): string
    {
        return "\n  <options=underscore>Exercise</>: {$this->requirements['description']}\n";
    }
}
