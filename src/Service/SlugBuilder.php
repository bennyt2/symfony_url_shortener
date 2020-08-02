<?php

namespace App\Service;

use App\Entity\Redirect;
use Doctrine\ORM\EntityManagerInterface;

class SlugBuilder
{
    /** @var EntityManagerInterface */
    protected $em;

    /**
     * SlugBuilder constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int|null $length
     * @return string
     */
    public function createSlug(?int $length = 6): string
    {
        $repo = $this->em->getRepository(Redirect::class);

        do {
            // No vowels to prevent curse words.
            $chars = '123456789bcdfghjklmnpqrstvwxyz';
            $slug = '';
            for ($i = 0; $i < $length; $i++) {
                $slug .= $chars[rand(0, strlen($chars)-1)];
            }
        } while ($repo->findOneBySlug($slug));

        return $slug;
    }
}
