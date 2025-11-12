<?php

namespace App\Controller;

use App\Enum\Language;
use App\Exception\UnsupportedLanguageException;
use App\Service\CivilRegistryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CivilRegistryController extends AbstractController
{
    #[Route('/api/v1/check-nni/{nni}', name: 'api_civil_registry_lookup', methods: ['GET'])]
    public function __invoke(string $nni, Request $request, CivilRegistryService $civilRegistryService): JsonResponse
    {
        $languageQuery = $request->query->get('lang');

        try {
            $language = Language::fromQuery($languageQuery);
        } catch (\InvalidArgumentException) {
            throw new UnsupportedLanguageException((string) $languageQuery);
        }

        $payload = $civilRegistryService
            ->findCitizen($nni, $language)
            ->toArray();

        return $this->json($payload);
    }
}

