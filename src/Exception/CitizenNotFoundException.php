<?php

namespace App\Exception;

use RuntimeException;

class CitizenNotFoundException extends RuntimeException
{
    public function __construct(
        private readonly string $nni,
    ) {
        parent::__construct(sprintf('Citizen with NNI "%s" was not found.', $nni));
    }

    public function getNni(): string
    {
        return $this->nni;
    }
}

