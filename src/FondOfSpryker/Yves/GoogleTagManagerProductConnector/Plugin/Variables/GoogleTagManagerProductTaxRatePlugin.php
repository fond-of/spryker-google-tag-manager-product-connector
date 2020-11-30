<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Plugin\Variables;

use FondOfSpryker\Yves\GoogleTagManagerExtension\Dependency\GoogleTagManagerVariableBuilderPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorFactory getFactory()
 */
class GoogleTagManagerProductTaxRatePlugin extends AbstractPlugin implements GoogleTagManagerVariableBuilderPluginInterface
{
    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function addVariable(string $page, array $params): array
    {
        return $this->getFactory()
            ->createGoogleTagManagerProductConnectorModel()
            ->getTaxRate($page, $params);
    }
}