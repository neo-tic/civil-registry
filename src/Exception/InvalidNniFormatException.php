<?php

namespace App\Exception;

use RuntimeException;

class InvalidNniFormatException extends RuntimeException
{
    public function __construct(
        private readonly string $nni,
    ) {
        parent::__construct(sprintf('The provided NNI "%s" is not valid.', $nni));
    }

    public function getNni(): string
    {
        return $this->nni;
    }
}

