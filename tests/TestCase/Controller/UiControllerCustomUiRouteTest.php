<?php
declare(strict_types=1);

namespace Cstaf\Swagger\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class UiControllerCustomUiRouteTest extends IntegrationTestCase
{
    /**
     * @var string Full path to temporary swagger.php configuration file.
     */
    public $tempConfig;

    /**
     * setUp method.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useHttpServer(true);
        $configTemplate = APP . 'config' . DS . 'swagger.php.ui.custom_route';
        $this->tempConfig = APP . 'config' . DS . 'swagger.php';
        copy($configTemplate, $this->tempConfig);
    }

    /**
     * tearDown method.
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unlink($this->tempConfig);
    }

    /**
     * Make sure the custom UI route is connected and serves Petstore document.
     *
     * @return void
     *
     * @throws \PHPUnit\Exception
     */
    public function testCustomRouteSuccess()
    {
        // default route
        $this->get('/custom-ui-route');
        $this->assertResponseOk();
        $this->assertResponseContains('<body class="swagger-section">');
        $this->assertResponseContains('http://petstore.swagger.io/v2/swagger.json');
    }

    /**
     * Make sure the default UI route is no longer connected.
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testDefaultRouteFail()
    {
        // default route should no longer function
        $this->get('/alt3/swagger');
        $this->assertResponseError();
        $this->assertResponseContains('Error: Missing Route');
    }
}
