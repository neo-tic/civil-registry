<?php

namespace App\Service;

use App\Dto\CitizenResponseDto;
use App\Enum\Language;
use App\Exception\CitizenNotFoundException;
use App\Exception\InvalidNniFormatException;
use App\Repository\CitizenRepository;
use App\Validator\NniValidator;

class CivilRegistryService
{
    public function __construct(
        private readonly CitizenRepository $citizenRepository,
        private readonly NniValidator $nniValidator,
    ) {
    }

    public function findCitizen(string $nni, Language $language): CitizenResponseDto
    {
        $normalisedNni = $this->nniValidator->normalise($nni);

        if (!$this->nniValidator->validate($normalisedNni)) {
            throw new InvalidNniFormatException($nni);
        }

        $citizen = $this->citizenRepository->findOneByNni($normalisedNni);

        if ($citizen === null) {
            throw new CitizenNotFoundException($normalisedNni);
        }

        return CitizenResponseDto::fromEntity($citizen, $language);
    }
}

