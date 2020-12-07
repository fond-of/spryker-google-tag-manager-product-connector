<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Plugin\DataLayer;

use FondOfSpryker\Yves\GoogleTagManagerExtension\Dependency\GoogleTagManagerDataLayerExpanderPluginInterface;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory getFactory()
 */
class ProductDataLayerExpanderPlugin extends AbstractPlugin implements GoogleTagManagerDataLayerExpanderPluginInterface
{
    /**
     * @param string $pageType
     * @param array $twigVariableBag
     *
     * @return bool
     */
    public function isApplicable(string $pageType, array $twigVariableBag = []): bool
    {
        return $pageType === ModuleConstants::PAGE_TYPE_PRODUCT
            && isset($twigVariableBag[ModuleConstants::PARAM_PRODUCT])
            && $twigVariableBag[ModuleConstants::PARAM_PRODUCT] instanceof ProductViewTransfer;
    }

    /**
     * @param string $page
     * @param array $twigVariableBag
     * @param array $dataLayer
     *
     * @return array
     */
    public function expand(string $page, array $twigVariableBag, array $dataLayer): array
    {
        return $this->getFactory()
            ->createDataLayerExpander()
            ->expand($page, $twigVariableBag, $dataLayer);
    }
}
