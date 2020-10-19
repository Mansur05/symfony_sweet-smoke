<?php


namespace App\Naming;


use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class SlugUsingNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping): string
    {
        return $object->getSlug() . '_' . $object->getThumbnailFile()->getClientOriginalName();
    }
}