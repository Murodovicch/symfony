<?php

declare(strict_types=1);

namespace App\Component\User;

class FindCategoryDto
{
    public function __construct(
        private string $name
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}