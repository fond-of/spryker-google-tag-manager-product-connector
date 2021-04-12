<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Plugin\TwigParameterBagExpander;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerExtension\Dependency\TwigParameterBagExpanderPluginInterface;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory getFactory()
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig getConfig()()
 */
class ProductAbstractTwigParameterBagExpanderPlugin extends AbstractPlugin implements TwigParameterBagExpanderPluginInterface
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
     * @param array $twigVariableBag
     *
     * @return array
     */
    public function expand($twigVariableBag): array
    {
         $twigVariableBag[ModuleConstants::PARAM_PRODUCT_ABSTRACT] = (new ProductAbstractTransfer())
            ->fromArray($twigVariableBag[ModuleConstants::PARAM_PRODUCT]->toArray(), true);

        return $twigVariableBag;
    }
}
