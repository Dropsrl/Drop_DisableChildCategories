<?php
/**
 * A Magento 2 module that disables child categories when parent category on admin is disabled
 * Copyright (C) 2019 Drop S.R.L.
 * 
 * This file is part of Drop/DisableChildCategories.
 * 
 * Drop/DisableChildCategories is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Drop\DisableChildCategories\Observer;

use \Magento\Framework\Message\ManagerInterface;
use \Psr\Log\LoggerInterface;

class CatalogCategorySaveAfter implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * CatalogCategorySaveAfter constructor.
     *
     * @param ManagerInterface $messageManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        ManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
    }

    /**
     * CatalogCategorySaveAfter observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return CatalogCategorySaveAfter
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = $observer->getEvent()->getCategory();
        if(!$category) {
            return $this;
        }

        if($category->getIsActive()) {
            return $this;
        }

        $childrenCategories = $category->getChildrenCategories();
        $error = false;
        foreach($childrenCategories as $childCategory) {
            try {
                /** @var \Magento\Catalog\Model\Category $childCategory */
                if($childCategory->getIsActive()) {
                    $childCategory
                        ->setIsActive(0)
                        ->save();
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was an error disabling the child category: ' . $childCategory->getName() . ' (' . $childCategory->getEntityId() . ')'));
                $this->logger->critical($e);
                $error = true;
            }
        }

        if(!$error) {
            $this->messageManager->addSuccessMessage(__('All child categories have been disabled.'));
        }

        return $this;
    }
}
