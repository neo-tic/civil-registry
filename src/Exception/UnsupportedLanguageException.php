<?php

namespace App\Exception;

use RuntimeException;

class UnsupportedLanguageException extends RuntimeException
{
    public function __construct(
        private readonly string $language,
    ) {
        parent::__construct(sprintf('Unsupported language "%s".', $language));
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
}

