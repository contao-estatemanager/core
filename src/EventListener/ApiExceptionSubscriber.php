<?php

namespace ContaoEstateManager\EstateManager\EventListener;

use ContaoEstateManager\EstateManager\Exception\ApiBaseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(RequestEvent $event)
    {
        $e = $event->getThrowable();

        if (!$e instanceof ApiBaseException) {
            return;
        }

       $response = new JsonResponse([
           'error'   => 1,
           'message' => $e->getMessage(),
           'code'    => $e->getCode()
       ]);

       $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}
