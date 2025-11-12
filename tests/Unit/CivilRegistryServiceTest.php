<?php

namespace App\Tests\Unit;

use App\Dto\CitizenResponseDto;
use App\Entity\Citizen;
use App\Enum\Language;
use App\Exception\CitizenNotFoundException;
use App\Exception\InvalidNniFormatException;
use App\Repository\CitizenRepository;
use App\Service\CivilRegistryService;
use App\Validator\NniValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CivilRegistryServiceTest extends TestCase
{
    private CitizenRepository&MockObject $repository;

    private CivilRegistryService $service;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(CitizenRepository::class);
        $this->service = new CivilRegistryService($this->repository, new NniValidator());
    }

    public function testFindCitizenReturnsDto(): void
    {
        $citizen = $this->createCitizen();

        $this->repository
            ->expects(self::once())
            ->method('findOneByNni')
            ->with('1234567890')
            ->willReturn($citizen);

        $dto = $this->service->findCitizen('1234567890', Language::French);

        self::assertInstanceOf(CitizenResponseDto::class, $dto);
        $payload = $dto->toArray();

        self::assertSame('1234567890', $payload['data']['nni']);
        self::assertSame('1990-04-01', $payload['data']['date_of_birth']);
        self::assertSame('Mohamed', $payload['data']['first_name']);
        self::assertSame(Language::French->value, $payload['meta']['language']);
    }

    public function testInvalidNniThrowsException(): void
    {
        $this->expectException(InvalidNniFormatException::class);

        $this->service->findCitizen('invalid', Language::French);
    }

    public function testMissingCitizenThrowsException(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('findOneByNni')
            ->with('1234567890')
            ->willReturn(null);

        $this->expectException(CitizenNotFoundException::class);

        $this->service->findCitizen('1234567890', Language::French);
    }

    private function createCitizen(): Citizen
    {
        $citizen = new Citizen();
        $citizen
            ->setNni('1234567890')
            ->setFirstNameFr('Mohamed')
            ->setFirstNameAr('محمد')
            ->setLastNameFr('Ould Ahmed')
            ->setLastNameAr('ولد أحمد')
            ->setGenderFr('Masculin')
            ->setGenderAr('ذكر')
            ->setDateOfBirth(new \DateTimeImmutable('1990-04-01'))
            ->setPlaceOfBirthFr('Nouakchott')
            ->setPlaceOfBirthAr('نواكشوط')
            ->setMaritalStatusFr('Marié')
            ->setMaritalStatusAr('متزوج')
            ->setNationalityFr('Mauritanienne')
            ->setNationalityAr('موريتانية')
            ->setAddressFr('Quartier Tevragh-Zeina, Nouakchott, Mauritanie')
            ->setAddressAr('حي تفرغ زينة، نواكشوط، موريتانيا');

        return $citizen;
    }
}

