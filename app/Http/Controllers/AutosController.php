<?php

namespace App\Http\Controllers;

use App\Exceptions\AutoUpdateException;
use App\Exports\AutoExport;
use App\Http\Requests\Auto\AutoCreateRequest;
use App\Http\Requests\Auto\AutosSearchRequest;
use App\Http\Requests\Auto\AutoUpdateRequest;
use App\Http\Resources\AutoResource;
use App\Models\Auto;
use App\Repository\AutosRepository;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AutosController extends Controller
{
    public function __construct(
        private readonly AutosRepository $autosRepository,
    ) {
    }

    public function index(AutosSearchRequest $request): JsonResponse
    {
        $paginated = Auto::query()->search($request->validated());

        return response()->json([
            'data' => AutoResource::collection($paginated),
        ]);
    }

    /**
     * @throws AutoUpdateException
     */
    public function store(AutoCreateRequest $request): JsonResponse
    {
        $data = $request->validated('auto');

        $auto = $this->autosRepository->create($data);

        return response()->json([
            'auto' => new AutoResource($auto),
        ], 201);
    }

    /**
     * @throws AutoUpdateException
     */
    public function update(Auto $auto, AutoUpdateRequest $request): JsonResponse
    {
        $data = $request->validated('auto');
        $auto = $this->autosRepository->update($auto, $data);

        return response()->json([
            'auto' => new AutoResource($auto),
        ]);
    }

    public function destroy(Auto $auto): JsonResponse
    {
        $this->autosRepository->remove($auto);

        return response()->json([
            'success' => true,
            'message' => 'Record removed',
            'auto' => new AutoResource($auto),
        ]);
    }

    public function export(AutosSearchRequest $request): BinaryFileResponse
    {
        return Excel::download(new AutoExport($request->validated()), 'autos.xls');
    }
}
