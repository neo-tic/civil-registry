<?php

namespace App\EventSubscriber;

use App\Exception\CitizenNotFoundException;
use App\Exception\InvalidNniFormatException;
use App\Exception\UnsupportedLanguageException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof InvalidNniFormatException) {
            $event->setResponse($this->buildResponse(
                status: Response::HTTP_BAD_REQUEST,
                code: 'INVALID_NNI_FORMAT',
                messages: [
                    'fr' => 'Le format du Numéro National d’Identification (NNI) est invalide. Il doit contenir exactement 10 chiffres.',
                    'ar' => 'تنسيق الرقم الوطني للتعريف غير صالح. يجب أن يتكون من 10 أرقام بالضبط.',
                ],
                details: [
                    'nni' => $exception->getNni(),
                ],
            ));

            return;
        }

        if ($exception instanceof UnsupportedLanguageException) {
            $event->setResponse($this->buildResponse(
                status: Response::HTTP_BAD_REQUEST,
                code: 'UNSUPPORTED_LANGUAGE',
                messages: [
                    'fr' => 'Le paramètre de langue fourni n’est pas pris en charge. Utilisez "fr", "ar" ou "both".',
                    'ar' => 'معلمة اللغة المقدمة غير مدعومة. يرجى استخدام "fr" أو "ar" أو "both".',
                ],
                details: [
                    'language' => $exception->getLanguage(),
                ],
            ));

            return;
        }

        if ($exception instanceof CitizenNotFoundException) {
            $event->setResponse($this->buildResponse(
                status: Response::HTTP_NOT_FOUND,
                code: 'CITIZEN_NOT_FOUND',
                messages: [
                    'fr' => 'Aucun citoyen n’a été trouvé pour le NNI fourni.',
                    'ar' => 'لم يتم العثور على أي مواطن للرقم الوطني المقدم.',
                ],
                details: [
                    'nni' => $exception->getNni(),
                ],
            ));

            return;
        }

        // Let Symfony handle other exceptions (will return HTML or default JSON if configured)
    }

    private function buildResponse(int $status, string $code, array $messages, array $details): JsonResponse
    {
        $payload = [
            'error' => [
                'status' => $status,
                'code' => $code,
                'message' => $messages,
                'details' => $details,
            ],
            'meta' => [
                'disclaimer' => [
                    'fr' => 'Données fictives fournies uniquement à des fins de test et de prototypage.',
                    'ar' => 'البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط.',
                ],
                'timestamp' => (new \DateTimeImmutable())->format(DATE_ATOM),
            ],
        ];

        return new JsonResponse($payload, $status);
    }
}

