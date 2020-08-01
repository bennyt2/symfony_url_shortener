<?php

namespace App\Service;

class SlugBuilder
{
    /**
     * @param int|null $length
     * @return string
     */
    public function createSlug(?int $length = 6): string
    {
        // No vowels to prevent curse words.
        $chars = '123456789bcdfghjklmnpqrstvwxyz';
        $slug = '';
        for ($i = 0; $i < $length; $i++) {
            $slug .= $chars[rand(0, strlen($chars)-1)];
        }

        return $slug;
    }
}
