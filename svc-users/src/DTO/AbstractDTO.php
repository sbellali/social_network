<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use ReflectionClass;

class AbstractDTO
{
    public function fill(AbstractEntity $entity)
    {
        $reflectionClass = new ReflectionClass($this);
        foreach ($reflectionClass->getProperties() as $property) {
            $propertyName = $property->getName();
            $propertyNameFirstUpper = ucfirst($propertyName);
            $setterName = 'set' . $propertyNameFirstUpper;
            $getterName = 'get' . $propertyNameFirstUpper;
            $entity->{$setterName}($this->{$getterName}());
        }
    }

    public function extract(AbstractEntity $entity)
    {
        $reflectionClass = new ReflectionClass($this);
        foreach ($reflectionClass->getProperties() as $property) {
            $propertyName = $property->getName();
            $propertyNameFirstUpper = ucfirst($propertyName);
            $setterName = 'set' . $propertyNameFirstUpper;
            $getterName = 'get' . $propertyNameFirstUpper;
            $this->{$setterName}($entity->{$getterName});
        }
    }
}