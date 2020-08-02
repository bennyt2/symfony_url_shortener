<?php

namespace App\Tests\Controller;

use App\Repository\RedirectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RedirectControllerTest extends WebTestCase
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var RedirectRepository */
    protected $repo;

    /** @var KernelBrowser */
    protected static $client;

    public function setUp(): void
    {
        if (!self::$client) {
            self::$client = static::createClient();
        }
    }

    public function tearDown(): void
    {
        $this->repo = self::$container->get('App\Repository\RedirectRepository');
        $this->em = self::$container->get('Doctrine\ORM\EntityManagerInterface');

        // Remove all redirects.
        $redirects = $this->repo->findAll();

        foreach ($redirects as $redirect) {
            $this->em->remove($redirect);
        }

        $this->em->flush();
    }

    /**
     * @group functionalTests
     */
    public function testIndexLoadsSuccessfully()
    {
        self::$client->request('GET', '/');

        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());
    }

    /**
     * @group functionalTests
     */
    public function testFormSuccessfulSubmission()
    {
        self::$client->followRedirects();

        $crawler = self::$client->request('GET', '/');

        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'http://example.com',
            'redirect[slug]' => 'abcdef',
        ]);

        $this->assertEquals(
            'abcdef',
            $crawler
                ->filter('h5.card-title')
                ->eq(0)
                ->text()
            )
        ;
    }

    /**
     * @group functionalTests
     */
    public function testValidationFailures()
    {
        self::$client->followRedirects();

        $crawler = self::$client->request('GET', '/');

        // URL is invalid
        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'example.com',
            'redirect[slug]' => 'abcdef',
        ]);

        $this->assertStringContainsString('This value is not a valid URL.', self::$client->getResponse()->getContent());

        // Slug is too short
        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'http://example.com',
            'redirect[slug]' => 'abcd',
        ]);

        $this->assertStringContainsString(
            'This value is too short. It should have 5 characters or more.',
            self::$client->getResponse()->getContent()
        );

        // Slug is too long
        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'http://example.com',
            'redirect[slug]' => 'abcdefghij',
        ]);

        $this->assertStringContainsString(
            'This value is too long. It should have 9 characters or less.',
            self::$client->getResponse()->getContent()
        );

        // Form is valid.
        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'http://example.com',
            'redirect[slug]' => 'abcdef',
        ]);

        $this->assertEquals(
            'abcdef',
            $crawler
                ->filter('h5.card-title')
                ->eq(0)
                ->text()
        );

        $crawler = self::$client->request('GET', '/');

        // Attempt to submit non-unique URL
        $crawler = self::$client->submitForm('Create Redirect', [
            'redirect[url]' => 'http://example.com',
            'redirect[slug]' => 'abcdef',
        ]);

        $this->assertStringContainsString(
            'is already in use. Please enter a new slug or erase for an auto-generated slug.',
            self::$client->getResponse()->getContent()
        );
    }
}
