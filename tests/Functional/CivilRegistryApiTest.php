<?php

namespace App\Tests\Functional;

use App\DataFixtures\CitizenFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CivilRegistryApiTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        static::ensureKernelShutdown();

        $this->client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager = $entityManager;

        $this->resetSchema();
        $this->loadFixtures(new CitizenFixtures());
    }

    protected function tearDown(): void
    {
        $this->client->getKernel()->shutdown();
        $this->entityManager->close();
        unset($this->entityManager, $this->client);

        parent::tearDown();
    }

    public function testLookupReturnsCitizenInFrenchByDefault(): void
    {
        $this->client->request('GET', '/api/v1/check-nni/1200000000');

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        $payload = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('fr', $payload['meta']['language']);
        self::assertIsString($payload['data']['first_name']);
        self::assertIsString($payload['data']['last_name']);
        self::assertArrayHasKey('disclaimer', $payload['meta']);
    }

    public function testLookupReturnsArabicWhenRequested(): void
    {
        $this->client->request('GET', '/api/v1/check-nni/1200000001?lang=ar');

        self::assertResponseIsSuccessful();
        $payload = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('ar', $payload['meta']['language']);
        self::assertIsString($payload['data']['first_name']);
    }

    public function testLookupReturnsBothLanguagesWhenRequested(): void
    {
        $this->client->request('GET', '/api/v1/check-nni/1200000002?lang=both');

        self::assertResponseIsSuccessful();
        $payload = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('both', $payload['meta']['language']);
        self::assertIsArray($payload['data']['first_name']);
        self::assertArrayHasKey('fr', $payload['data']['first_name']);
        self::assertArrayHasKey('ar', $payload['data']['first_name']);
    }

    public function testInvalidNniReturnsBadRequest(): void
    {
        $this->client->request('GET', '/api/v1/check-nni/ABC');

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $payload = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('INVALID_NNI_FORMAT', $payload['error']['code']);
        self::assertArrayHasKey('fr', $payload['error']['message']);
        self::assertArrayHasKey('ar', $payload['error']['message']);
    }

    public function testUnknownNniReturnsNotFound(): void
    {
        $this->client->request('GET', '/api/v1/check-nni/9999999999');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $payload = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('CITIZEN_NOT_FOUND', $payload['error']['code']);
    }

    private function resetSchema(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);

        $schemaTool->dropDatabase();

        if (!empty($metadata)) {
            $schemaTool->createSchema($metadata);
        }
    }

    private function loadFixtures(object ...$fixtures): void
    {
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);

        $executor->purge();
        $executor->execute($fixtures);
    }
}

