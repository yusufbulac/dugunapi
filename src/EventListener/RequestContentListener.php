<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class RequestContentListener
{
    public function onKernelRequest(RequestEvent $event){
        if(!$event->isMasterRequest()){
            return;
        }

        $request = $event->getRequest();
        $content = $request->getContent();

        if (empty($content)) {
            $content = '{}';
        }

        $data = json_decode($content, true);

        if (is_array($data)) {
            $request->request = new ParameterBag($data);
        } else {
            throw new BadRequestHttpException('Invalid JSON data');
        }

        if($request->headers->get("Content-Type") !== "application/json"){
            throw new UnsupportedMediaTypeHttpException("Invalid Content_Type");
        }
    }
}