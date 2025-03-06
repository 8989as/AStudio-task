<?php

namespace App\Repositories;

use App\Models\AttributeValue;

class AttributeValueRepository extends BaseRepository
{
    public function __construct(AttributeValue $attributeValue)
    {
        parent::__construct($attributeValue);
    }
}
