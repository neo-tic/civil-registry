<?php

namespace App\Validator;

class NniValidator
{
    /**
     * Mauritanian NNIs are 10 digits. We accept optional leading zeros.
     */
    private const REGEX = '/^\d{10}$/';

    public function validate(string $nni): bool
    {
        $normalised = preg_replace('/\s+/', '', $nni);

        return is_string($normalised) && preg_match(self::REGEX, $normalised) === 1;
    }

    public function normalise(string $nni): string
    {
        return preg_replace('/\s+/', '', $nni) ?? $nni;
    }
}

