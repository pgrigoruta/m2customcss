<?php

namespace Pgrigoruta\CustomCSS\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ObserverInterface;

class ConfigObserver implements ObserverInterface {

    const XML_PATH_CUSTOM_CSS = 'dev/custom_css/custom_css';

    /** @var ScopeConfigInterface  */
    protected $scopeConfig;

    /** @var \Magento\Framework\Filesystem  */
    protected $filesystem;

    /**
     * ConfigObserver constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(ScopeConfigInterface $scopeConfig,
                                \Magento\Framework\Filesystem $filesystem
    )
    {
        $this->filesystem = $filesystem;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customCss = $this->scopeConfig->getValue(self::XML_PATH_CUSTOM_CSS);
        $customCssFile = $this->getCustomCssFileWithPath();
        $this->writeCustomCss($customCssFile,$customCss);
    }

    /**
     * @return string
     */
    protected function getCustomCssFileWithPath() {
        return $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath().'custom.css';
    }

    /**
     * @param $file
     * @param $css
     */
    protected function writeCustomCss($file,$css) {
        $file = @fopen($file,"w+");
        @flock($file, LOCK_EX);
        @fwrite($file,$css);
        @flock($file, LOCK_UN);
        @fclose($file);
    }
}