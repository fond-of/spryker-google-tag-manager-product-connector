<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Plugin\TwigParameterBagExpander;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductAbstractTwigParameterBagExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerExtension\Dependency\TwigParameterBagExpanderPluginInterface
     */
    protected $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory
     */
    protected $factoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(GoogleTagManagerProductConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductAbstractTwigParameterBagExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->assertEquals(true, $this->plugin->isApplicable('product', [
            ModuleConstants::PARAM_PRODUCT => new ProductViewTransfer(),
        ]));
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $response = $this->plugin->expand([ModuleConstants::PARAM_PRODUCT => new ProductViewTransfer()]);

        static::assertIsArray($response);
        static::assertArrayHasKey(ModuleConstants::PARAM_PRODUCT_ABSTRACT, $response);
        static::assertInstanceOf(ProductAbstractTransfer::class, $response[ModuleConstants::PARAM_PRODUCT_ABSTRACT]);
    }
}
