<?php

declare(strict_types=1);

namespace App\Component\User;

class MaxAgeDto
{
    public function __construct(
        private int $maxAge
    ) {
    }

    /**
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->maxAge;
    }
}
