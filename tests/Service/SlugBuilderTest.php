<?php

namespace App\Tests\Service;

use App\Service\SlugBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SlugBuilderTest extends KernelTestCase
{
    /** @var SlugBuilder */
    protected $slugBuilder;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->slugBuilder = self::$container->get('App\Service\SlugBuilder');
    }

    /**
     * @param int|null $lengthArg
     * @param int      $expectedLength
     *
     * @dataProvider createSlugProvider
     */
    public function testCreateSlug(?int $lengthArg, int $expectedLength)
    {
        if ($lengthArg === null) {
            $slug = $this->slugBuilder->createSlug();
        } else {
            $slug = $this->slugBuilder->createSlug($lengthArg);
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
