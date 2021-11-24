<?php

namespace ContaoEstateManager\EstateManager\EventListener;

use ContaoEstateManager\EstateManager\Exception\ApiBaseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Handle api exceptions
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(RequestEvent $event)
    {
        $r = $event->getRequest();
        $e = $event->getThrowable();

        if (!$e instanceof ApiBaseException && strpos($r->getPathInfo(), '/api/estatemanager') !== 0) {
            return;
        }

        $arrError = [
            'error'   => 1,
            'message' => $e->getMessage(),
            'code'    => $e->getCode()
        ];

        // Extend output in case of unforeseeable errors
        if((strpos($r->getPathInfo(), '/api/') === 0 && !$e instanceof ApiBaseException) || $r->get('debug') == 1)
        {
            $arrError['file'] = $e->getFile();
            $arrError['line'] = $e->getLine();
        }

        // Extend trace only if debug = 1
        if($r->get('debug') == 1)
        {
            $arrError['trace'] = $e->getTrace();
        }

       $event->setResponse(new JsonResponse($arrError));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
}
