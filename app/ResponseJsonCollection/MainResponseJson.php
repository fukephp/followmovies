<?php

namespace App\ResponseJsonCollection;

use App\Http\Resources\MovieResource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JustSteveKing\StatusCode\Http;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource as HttpJsonResource;

class MainResponseJson implements Responsable {

    private $data;
    private Http $status;

    public function __construct(HttpJsonResource|ResourceCollection|array $data, bool $success = true, mixed $message = null, Http $status = Http::OK)
    {
        $collectData = [
            'success'   => $success,
            'message'   => $message,
            'data'      => $data
        ];
        $this->data = $collectData;
        $this->status = $status;
    }

    public function toResponse($request): Response
    {
        return new JsonResponse($this->data, $this->status->value);
    }
}
