<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\VerificationController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\VerificationController Test Case
 *
 * @uses \App\Controller\VerificationController
 */
class VerificationControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Verification',
    ];
}
