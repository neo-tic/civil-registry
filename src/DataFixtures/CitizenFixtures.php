<?php

namespace App\DataFixtures;

use App\Entity\Citizen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CitizenFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fakerFr = Factory::create('fr_FR');
        $now = new \DateTimeImmutable('now');

        $maleFirstNames = [
            ['fr' => 'Mohamed', 'ar' => 'محمد'],
            ['fr' => 'Ahmed', 'ar' => 'أحمد'],
            ['fr' => 'Cheikh', 'ar' => 'الشيخ'],
            ['fr' => 'Sidi', 'ar' => 'سيدي'],
            ['fr' => 'Moussa', 'ar' => 'موسى'],
            ['fr' => 'Ismail', 'ar' => 'إسماعيل'],
            ['fr' => 'Abdallah', 'ar' => 'عبد الله'],
            ['fr' => 'Yahya', 'ar' => 'يحيى'],
            ['fr' => 'Salem', 'ar' => 'سالم'],
            ['fr' => 'Baba', 'ar' => 'بابه'],
        ];

        $femaleFirstNames = [
            ['fr' => 'Aminata', 'ar' => 'أميناتا'],
            ['fr' => 'Mariam', 'ar' => 'مريم'],
            ['fr' => 'Fatimetou', 'ar' => 'فطمتو'],
            ['fr' => 'Khadijetou', 'ar' => 'خديجتو'],
            ['fr' => 'Tekber', 'ar' => 'تكبر'],
            ['fr' => 'Zeinebou', 'ar' => 'زينب'],
            ['fr' => 'Nana', 'ar' => 'نانا'],
            ['fr' => 'Mouna', 'ar' => 'مونة'],
            ['fr' => 'Rakia', 'ar' => 'راكه'],
            ['fr' => 'Aissata', 'ar' => 'عيشة'],
        ];

        $lastNames = [
            ['fr' => 'Ould Abdel Aziz', 'ar' => 'ولد عبد العزيز'],
            ['fr' => 'Ould Cheikh', 'ar' => 'ولد الشيخ'],
            ['fr' => 'Ould Ahmed', 'ar' => 'ولد أحمد'],
            ['fr' => 'Ould Sidi', 'ar' => 'ولد سيدي'],
            ['fr' => 'Ould Salem', 'ar' => 'ولد سالم'],
            ['fr' => 'Mint Mohamed', 'ar' => 'منت محمد'],
            ['fr' => 'Mint Mbarek', 'ar' => 'منت امبارك'],
            ['fr' => 'Mint Lehbib', 'ar' => 'منت لحبيب'],
            ['fr' => 'Mint Ahmed', 'ar' => 'منت أحمد'],
            ['fr' => 'Mint Ely', 'ar' => 'منت إعل'],
        ];

        $cities = [
            ['fr' => 'Nouakchott', 'ar' => 'نواكشوط'],
            ['fr' => 'Nouadhibou', 'ar' => 'نواذيبو'],
            ['fr' => 'Kaédi', 'ar' => 'كيدي'],
            ['fr' => 'Kiffa', 'ar' => 'كيفه'],
            ['fr' => 'Atar', 'ar' => 'أطار'],
            ['fr' => 'Rosso', 'ar' => 'روصو'],
            ['fr' => 'Zouerate', 'ar' => 'ازويرات'],
            ['fr' => 'Tidjikja', 'ar' => 'تيجكجة'],
            ['fr' => 'Aioun el Atrouss', 'ar' => 'العيون'],
            ['fr' => 'Selibaby', 'ar' => 'سيلبابي'],
        ];

        $districts = [
            ['fr' => 'Tevragh-Zeina', 'ar' => 'تفرغ زينة'],
            ['fr' => 'Dar Naim', 'ar' => 'دار النعيم'],
            ['fr' => 'El Mina', 'ar' => 'الميناء'],
            ['fr' => 'Toujounine', 'ar' => 'توجونين'],
            ['fr' => 'Teyarett', 'ar' => 'تيارت'],
            ['fr' => 'Ksar', 'ar' => 'لكصر'],
            ['fr' => 'Sebkha', 'ar' => 'سبخة'],
            ['fr' => 'Arafat', 'ar' => 'عرفات'],
        ];

        $maritalStatuses = [
            'single' => ['fr' => 'Célibataire', 'ar' => 'أعزب/عزباء'],
            'married' => ['fr' => 'Marié(e)', 'ar' => 'متزوج/متزوجة'],
            'divorced' => ['fr' => 'Divorcé(e)', 'ar' => 'مطلق/مطلقة'],
            'widowed' => ['fr' => 'Veuf/Veuve', 'ar' => 'أرمل/أرملة'],
        ];

        $genderLabels = [
            'male' => ['fr' => 'Masculin', 'ar' => 'ذكر'],
            'female' => ['fr' => 'Féminin', 'ar' => 'أنثى'],
        ];

        $ageCategories = array_merge(
            array_fill(0, 20, 'minor'),
            array_fill(0, 60, 'adult'),
            array_fill(0, 20, 'senior'),
        );
        shuffle($ageCategories);

        $genderPool = array_merge(array_fill(0, 50, 'male'), array_fill(0, 50, 'female'));
        shuffle($genderPool);

        $nniBase = 1200000000;

        foreach (range(0, 99) as $index) {
            $genderKey = $genderPool[$index];
            $firstNameSource = $genderKey === 'male' ? $maleFirstNames : $femaleFirstNames;
            $firstName = $fakerFr->randomElement($firstNameSource);
            $lastName = $fakerFr->randomElement($lastNames);
            $city = $fakerFr->randomElement($cities);
            $district = $fakerFr->randomElement($districts);
            $maritalStatus = $this->pickWeightedMaritalStatus($maritalStatuses);
            $birthDate = $this->generateBirthDate($ageCategories[$index], $now, $fakerFr);

            $citizen = new Citizen();
            $citizen
                ->setNni(sprintf('%010d', $nniBase + $index))
                ->setFirstNameFr($firstName['fr'])
                ->setFirstNameAr($firstName['ar'])
                ->setLastNameFr($lastName['fr'])
                ->setLastNameAr($lastName['ar'])
                ->setGenderFr($genderLabels[$genderKey]['fr'])
                ->setGenderAr($genderLabels[$genderKey]['ar'])
                ->setDateOfBirth($birthDate)
                ->setPlaceOfBirthFr($city['fr'])
                ->setPlaceOfBirthAr($city['ar'])
                ->setMaritalStatusFr($maritalStatus['fr'])
                ->setMaritalStatusAr($maritalStatus['ar'])
                ->setNationalityFr('Mauritanienne')
                ->setNationalityAr('موريتانية')
                ->setAddressFr(sprintf('Quartier %s, %s, Mauritanie', $district['fr'], $city['fr']))
                ->setAddressAr(sprintf('حي %s، %s، موريتانيا', $district['ar'], $city['ar']));

            $manager->persist($citizen);
        }

        $manager->flush();
    }

    private function pickWeightedMaritalStatus(array $statuses): array
    {
        $weights = [
            'single' => 0.35,
            'married' => 0.45,
            'divorced' => 0.1,
            'widowed' => 0.1,
        ];

        $random = mt_rand() / mt_getrandmax();
        $cumulative = 0.0;

        foreach ($weights as $key => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$key];
            }
        }

        return $statuses['single'];
    }

    private function generateBirthDate(string $category, \DateTimeImmutable $now, \Faker\Generator $faker): \DateTimeImmutable
    {
        [$start, $end] = match ($category) {
            'minor' => [$now->modify('-17 years'), $now->modify('-12 months')],
            'adult' => [$now->modify('-50 years'), $now->modify('-18 years')],
            'senior' => [$now->modify('-85 years'), $now->modify('-51 years')],
            default => [$now->modify('-50 years'), $now->modify('-18 years')],
        };

        $dateTime = $faker->dateTimeBetween($start->format('Y-m-d'), $end->format('Y-m-d'));

        return \DateTimeImmutable::createFromMutable($dateTime);
    }
}

