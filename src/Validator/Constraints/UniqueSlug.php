<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueSlug extends Constraint
{
    public $message = '"{{ slug }}" is already in use. Please enter a new slug or erase for an auto-generated slug.';
}
