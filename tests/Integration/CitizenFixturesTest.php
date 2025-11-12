<?php

namespace App\Tests\Integration;

use App\DataFixtures\CitizenFixtures;
use App\Entity\Citizen;
use App\Repository\CitizenRepository;
use App\Tests\DatabaseTestCase;

class CitizenFixturesTest extends DatabaseTestCase
{
    private CitizenRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CitizenRepository $repository */
        $repository = static::getContainer()->get(CitizenRepository::class);
        $this->repository = $repository;

        $this->loadFixtures(new CitizenFixtures());
    }

    public function testFixtureLoadsHundredCitizens(): void
    {
        self::assertSame(100, $this->repository->count([]));
    }

    public function testGenderDistributionIsBalanced(): void
    {
        $citizens = $this->repository->findAll();

        $male = 0;
        $female = 0;

        foreach ($citizens as $citizen) {
            if ($citizen->getGenderFr() === 'Masculin') {
                ++$male;
            } elseif ($citizen->getGenderFr() === 'Féminin') {
                ++$female;
            }
        }

        self::assertSame(50, $male);
        self::assertSame(50, $female);
    }

    public function testAgeGroupDistributionMatchesSpecification(): void
    {
        $citizens = $this->repository->findAll();

        $minor = 0;
        $adult = 0;
        $senior = 0;

        $today = new \DateTimeImmutable('today');

        foreach ($citizens as $citizen) {
            $age = $citizen->getDateOfBirth()->diff($today)->y;

            if ($age < 18) {
                ++$minor;
            } elseif ($age <= 50) {
                ++$adult;
            } else {
                ++$senior;
            }
        }

        self::assertSame(20, $minor);
        self::assertSame(60, $adult);
        self::assertSame(20, $senior);
    }
}

