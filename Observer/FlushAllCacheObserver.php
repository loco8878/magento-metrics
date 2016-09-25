<?php
namespace Sectionio\Metrics\Observer;

use Magento\Framework\Event\ObserverInterface;

class FlushAllCacheObserver implements ObserverInterface
{
    /**
     * Application config object
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $config;

    /**
     * @var \Sectionio\Metrics\Model\PurgeCache
     */
    protected $purgeCache;

    /**
     * @param \Magento\PageCache\Model\Config $config
     * @param \Sectionio\Metrics\Model\PurgeCache $purgeCache
     */
    public function __construct(
        \Magento\PageCache\Model\Config $config,
        \Sectionio\Metrics\Model\PurgeCache $purgeCache
    ) {
        $this->config = $config;
        $this->purgeCache = $purgeCache;
    }

    /**
     * Flash Varnish cache
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->config->getType() == \Magento\PageCache\Model\Config::VARNISH && $this->config->isEnabled()) {
            $this->purgeCache->sendPurgeRequest('.*');
        }
    }
}