<?php

namespace App\Tests\Service;

use App\Service\SlugBuilder;
use PHPUnit\Framework\TestCase;

class SlugBuilderTest extends TestCase
{
    /**
     * @param int|null $lengthArg
     * @param int      $expectedLength
     *
     * @dataProvider createSlugProvider
     */
    public function testCreateSlug(?int $lengthArg, int $expectedLength)
    {
        $slugBuilder = new SlugBuilder();

        if ($lengthArg === null) {
            $slug = $slugBuilder->createSlug();
        } else {
            $slug = $slugBuilder->createSlug($lengthArg);
        }
        $this->assertEquals($expectedLength, strlen($slug));
    }

    public function createSlugProvider()
    {
        return [
            'default' => [null, 6],
            '7' => [7, 7],
            '1' => [1, 1],
        ];
    }
}
