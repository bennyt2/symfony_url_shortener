<?php

namespace App\Validator\Constraints;

use App\Entity\Redirect;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueSlugValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * UniqueSlugValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueSlug) {
            throw new UnexpectedTypeException($constraint, UniqueSlug::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $slug = $this->em->getRepository(Redirect::class)->findOneBySlug($value);

        if ($slug) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ slug }}', $value)
                ->addViolation();
        }
    }
}
