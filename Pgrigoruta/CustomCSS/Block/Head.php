<?php

namespace Pgrigoruta\CustomCSS\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Head extends Template {
    protected function getBaseMediaUrl() {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getCustomCSSFile() {
        return $this->getBaseMediaUrl(). 'custom.css';
    }
}