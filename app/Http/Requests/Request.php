<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Http\Request as BaseRequest;

class Request
{
    public BaseRequest $request;

    public function __construct(BaseRequest $request)
    {
        $this->request = $request;
    }

    public function toArray(): array
    {
        return $this->request->toArray();
    }
}
