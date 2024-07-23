<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutoMake\AutoMakeAutoCompleteRequest;
use App\Repository\AutoMakesRepository;
use Illuminate\Http\JsonResponse;

class AutoMakesController extends Controller
{
    public function __construct(
        private readonly AutoMakesRepository $repository,
    ) {
    }

    public function autoComplete(AutoMakeAutoCompleteRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->repository
            ->autoCompleteByName($data['name'])
            ->load(['models']);

        return response()->json([
            'result' => $result,
        ]);
    }
}
