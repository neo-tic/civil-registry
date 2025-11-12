<?php

namespace App\Dto;

use App\Entity\Citizen;
use App\Enum\Language;

class CitizenResponseDto
{
    private function __construct(
        private readonly array $data,
        private readonly array $meta,
    ) {
    }

    public static function fromEntity(Citizen $citizen, Language $language): self
    {
        $fields = [
            'first_name' => [
                Language::French->value => $citizen->getFirstNameFr(),
                Language::Arabic->value => $citizen->getFirstNameAr(),
            ],
            'last_name' => [
                Language::French->value => $citizen->getLastNameFr(),
                Language::Arabic->value => $citizen->getLastNameAr(),
            ],
            'gender' => [
                Language::French->value => $citizen->getGenderFr(),
                Language::Arabic->value => $citizen->getGenderAr(),
            ],
            'place_of_birth' => [
                Language::French->value => $citizen->getPlaceOfBirthFr(),
                Language::Arabic->value => $citizen->getPlaceOfBirthAr(),
            ],
            'marital_status' => [
                Language::French->value => $citizen->getMaritalStatusFr(),
                Language::Arabic->value => $citizen->getMaritalStatusAr(),
            ],
            'nationality' => [
                Language::French->value => $citizen->getNationalityFr(),
                Language::Arabic->value => $citizen->getNationalityAr(),
            ],
            'address' => [
                Language::French->value => $citizen->getAddressFr(),
                Language::Arabic->value => $citizen->getAddressAr(),
            ],
        ];

        $data = [
            'nni' => $citizen->getNni(),
            'date_of_birth' => $citizen->getDateOfBirth()->format('Y-m-d'),
        ];

        foreach ($fields as $key => $value) {
            $data[$key] = self::localise($value, $language);
        }

        $meta = [
            'language' => $language->value,
            'retrieved_at' => (new \DateTimeImmutable())->format(DATE_ATOM),
            'source' => 'Civil Registry API Simulation – Not an official government service',
            'disclaimer' => [
                Language::French->value => 'Données fictives fournies uniquement à des fins de test et de prototypage. Ce service n’est pas affilié au gouvernement mauritanien.',
                Language::Arabic->value => 'البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط. هذه الخدمة غير تابعة للحكومة الموريتانية.',
            ],
        ];

        return new self($data, $meta);
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
        ];
    }

    private static function localise(array $translations, Language $language): array|string
    {
        return match ($language) {
            Language::French => $translations[Language::French->value],
            Language::Arabic => $translations[Language::Arabic->value],
            Language::Both => [
                Language::French->value => $translations[Language::French->value],
                Language::Arabic->value => $translations[Language::Arabic->value],
            ],
        };
    }
}

