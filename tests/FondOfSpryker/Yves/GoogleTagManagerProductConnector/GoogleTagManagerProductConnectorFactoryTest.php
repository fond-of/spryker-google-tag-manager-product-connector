<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\Container;

class GoogleTagManagerProductConnectorFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $taxProductConnectorClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Yves\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPluginMock;

    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->taxProductConnectorClient = $this->getMockBuilder(GoogleTagManagerProductConnectorToTaxProductConnectorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->moneyPluginMock = $this->getMockBuilder(MoneyPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new GoogleTagManagerProductConnectorFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateDataLayerExpander(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->moneyPluginMock, $this->taxProductConnectorClient);

        $this->assertInstanceOf(
            DataLayerExpanderInterface::class,
            $this->factory->createDataLayerExpander()
        );
    }

    /**
     * @return void
     */
    public function testGetMoneyPlugin(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->moneyPluginMock);

        $this->assertInstanceOf(
            MoneyPluginInterface::class,
            $this->factory->getMoneyPlugin()
        );
    }

    /**
     * @return void
     */
    public function testGetTaxProductConnectorClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->taxProductConnectorClient);

        $this->assertInstanceOf(
            GoogleTagManagerProductConnectorToTaxProductConnectorInterface::class,
            $this->factory->getTaxProductConnectorClient()
        );
    }
}
