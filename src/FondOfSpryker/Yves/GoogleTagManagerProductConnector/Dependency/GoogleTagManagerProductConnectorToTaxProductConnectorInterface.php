<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface GoogleTagManagerProductConnectorToTaxProductConnectorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function getNetPriceForProduct(ProductAbstractTransfer $productTransfer): ProductAbstractTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function getTaxAmountForProduct(ProductAbstractTransfer $productTransfer): ProductAbstractTransfer;
}
