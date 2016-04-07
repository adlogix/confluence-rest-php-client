<?php
/*
 * This file is part of the Adlogix package.
 *
 * (c) Allan Segebarth <allan@adlogix.eu>
 * (c) Jean-Jacques Courtens <jjc@adlogix.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Adlogix\Confluence\Client\Entity\Connect;


class DescriptorLifecycle
{

    /**
     * @var string
     */
    private $disabled;
    
    /**
     * @var string
     */
    private $enabled;
    
    /**
     * @var string
     */
    private $installed;
    
    /**
     * @var string
     */
    private $uninstalled;

    /**
     * @return string
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param string $disabled
     *
     * @return DescriptorLifecycle
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
     *
     * @return DescriptorLifecycle
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstalled()
    {
        return $this->installed;
    }

    /**
     * @param string $installed
     *
     * @return DescriptorLifecycle
     */
    public function setInstalled($installed)
    {
        $this->installed = $installed;
        return $this;
    }

    /**
     * @return string
     */
    public function getUninstalled()
    {
        return $this->uninstalled;
    }

    /**
     * @param string $uninstalled
     *
     * @return DescriptorLifecycle
     */
    public function setUninstalled($uninstalled)
    {
        $this->uninstalled = $uninstalled;
        return $this;
    }


}
