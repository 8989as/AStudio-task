<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;

class AttributeService
{
    protected $attributeRepository;
    protected $attributeValueRepository;

    public function __construct(AttributeRepository $attributeRepository, AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function createAttribute($data)
    {
        return $this->attributeRepository->create($data);
    }

    public function setAttributeValues($entityId, $attributes)
    {
        foreach ($attributes as $attributeId => $value) {
            $this->attributeValueRepository->updateOrCreate(
                ['attribute_id' => $attributeId, 'entity_id' => $entityId],
                ['value' => $value]
            );
        }
    }
}
