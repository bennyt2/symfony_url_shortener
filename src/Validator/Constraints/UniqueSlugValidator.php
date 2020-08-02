<?php

namespace App\Validator\Constraints;

use App\Entity\Redirect;
use App\Repository\RedirectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueSlugValidator extends ConstraintValidator
{
    /** @var RedirectRepository */
    protected $repo;

    /**
     * UniqueSlugValidator constructor.
     * @param RedirectRepository $repo
     */
    public function __construct(RedirectRepository $repo)
    {
        $this->repo = $repo;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueSlug) {
            throw new UnexpectedTypeException($constraint, UniqueSlug::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $slug = $this->repo->findOneBySlug($value);

        if ($slug) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ slug }}', $value)
                ->addViolation();
        }
    }
}
