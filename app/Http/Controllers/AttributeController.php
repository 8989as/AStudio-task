<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:text,number,date,select',
            ]);

            $data = $this->attributeService->createAttribute($validatedData);

            return ResponseFormatter::format(
                200,
                'Attribute created successfuly',
                $data
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function setAttributeValues(Request $request, $projectId)
    {
        try {
            $validatedData = $request->validate([
                'attributes' => 'required|array',
                'attributes.*.id' => 'required|exists:attributes,id',
                'attributes.*.value' => 'required|string',
            ]);

            $data = $this->attributeService->setAttributeValues($projectId, $validatedData['attributes']);

            return ResponseFormatter::format(
                200,
                'Attribute set successfuly',
                $data
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }
}
