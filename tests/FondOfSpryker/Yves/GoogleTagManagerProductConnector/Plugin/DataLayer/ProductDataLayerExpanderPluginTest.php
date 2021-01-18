<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Plugin\DataLayer;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductDataLayerExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface
     */
    protected $dataLayerExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory
     */
    protected $factoryMock;

    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerExtension\Dependency\GoogleTagManagerDataLayerExpanderPluginInterface
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->dataLayerExpanderMock = $this->getMockBuilder(DataLayerExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(GoogleTagManagerProductConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductDataLayerExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $result = $this->plugin->isApplicable('product', [
            ModuleConstants::PARAM_PRODUCT => new ProductViewTransfer(),
            ModuleConstants::PARAM_PRODUCT_ABSTRACT => new ProductAbstractTransfer(),
        ]);

        $this->assertEquals(true, $result);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createDataLayerExpander')
            ->willReturn($this->dataLayerExpanderMock);

        $this->plugin->expand('pageType', [], []);
    }
}
