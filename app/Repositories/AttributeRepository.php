<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository extends BaseRepository
{
    public function __construct(Attribute $attribute)
    {
        parent::__construct($attribute);
    }
}
