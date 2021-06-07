<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverter;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class DataLayerExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceCartConnector\Converter\IntegerToDecimalConverterInterface
     */
    protected $integerToDecimalConverterMock;

    /**
     * @var DataLayerExpanderInterface
     */
    protected $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected $productViewTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->integerToDecimalConverterMock = $this->getMockBuilder(IntegerToDecimalConverter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new DataLayerExpander($this->integerToDecimalConverterMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('PRODUCT_NAME');

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(3999);

        $this->integerToDecimalConverterMock->expects(static::atLeastOnce())
            ->method('convert')
            ->willReturn(39.99);

        $result = $this->expander->expand('pageType', [
            ModuleConstants::PARAM_PRODUCT => $this->productViewTransferMock,
            ModuleConstants::PARAM_PRODUCT_ABSTRACT => $this->productAbstractTransferMock,
        ], []);

        static::assertArrayHasKey(ModuleConstants::FIELD_ID, $result);
        static::assertArrayHasKey(ModuleConstants::FIELD_NAME, $result);
        static::assertArrayHasKey(ModuleConstants::FIELD_SKU, $result);
        static::assertArrayHasKey(ModuleConstants::FIELD_PRICE, $result);
    }
}
