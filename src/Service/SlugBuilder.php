<?php

namespace App\Service;

use App\Entity\Redirect;
use App\Repository\RedirectRepository;
use Doctrine\ORM\EntityManagerInterface;

class SlugBuilder
{
    /** @var RedirectRepository */
    protected $repo;

    /**
     * SlugBuilder constructor.
     * @param RedirectRepository $repo
     */
    public function __construct(RedirectRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param int|null $length
     * @return string
     */
    public function createSlug(?int $length = 6): string
    {
        do {
            // No vowels to prevent curse words.
            $chars = '123456789bcdfghjklmnpqrstvwxyz';
            $slug = '';
            for ($i = 0; $i < $length; $i++) {
                $slug .= $chars[rand(0, strlen($chars)-1)];
            }
        } while ($this->repo->findOneBySlug($slug));

        return $slug;
    }
}
