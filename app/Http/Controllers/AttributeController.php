<?php

namespace App\Http\Controllers;

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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,date,select',
        ]);

        return response()->json($this->attributeService->createAttribute($data), 201);
    }

    public function setAttributeValues(Request $request, $projectId)
    {
        $data = $request->validate([
            'attributes' => 'required|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        $this->attributeService->setAttributeValues($projectId, $data['attributes']);

        return response()->json(['message' => 'Attributes updated successfully']);
    }
}
