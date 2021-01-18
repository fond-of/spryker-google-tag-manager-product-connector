<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverter;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface
     */
    protected $integerToDecimalConverterMock;

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

        $this->integerToDecimalConverterMock = $this->getMockBuilder(IntegerToDecimalConverter::class)
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
            ->willReturn($this->integerToDecimalConverterMock, $this->taxProductConnectorClient);

        $this->assertInstanceOf(
            DataLayerExpanderInterface::class,
            $this->factory->createDataLayerExpander()
        );
    }

    /**
     * @return void
     */
    public function testGetIntegerToDecimalConverter(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->integerToDecimalConverterMock);

        $this->assertInstanceOf(
            IntegerToDecimalConverterInterface::class,
            $this->factory->getIntegerToDecimalConverter()
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
