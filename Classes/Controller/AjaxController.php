<?php
declare(strict_types=1);
namespace Alm\AlmWishlist\Controller;

class AjaxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	public function initializeAction()
	{
		
	}
	
	public function wishlistAddAction()
	{
		if($GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist'))
		{
			$products = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist');
		}
		else
		{
			$products = array();
		}

		if($this->request->hasArgument('productId') && $this->request->hasArgument('productName'))
		{
			if(!array_key_exists($this->request->getArgument('productId'), $products))
			{
				$products[$this->request->getArgument('productId')] = $this->request->getArgument('productName');
			}
		}

		$GLOBALS['TSFE']->fe_user->setKey('ses', 'wishlist', $products);

		$this->view->assign('products', $products);
	}
	
	
	public function wishlistRemoveAction()
	{
		if($GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist'))
		{
			$products = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist');
			
			if($this->request->hasArgument('productId') && $this->request->hasArgument('productName'))
		    {
                if(array_key_exists($this->request->getArgument('productId'), $products))
                {
                    unset($products[$this->request->getArgument('productId')]);
                }
            }

            $GLOBALS['TSFE']->fe_user->setKey('ses', 'wishlist', $products);

			$this->view->assign('products', $products);
		}
	}


	public function wishlistUpdateAction()
	{
		if($GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist'))
		{
			$products = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist');
		}
		else
		{
			$products = array();
		}

		if($this->request->hasArgument('productId') && $this->request->hasArgument('productName'))
		{
			if(array_key_exists($this->request->getArgument('productId'), $products))
			{
				unset($products[$this->request->getArgument('productId')]);
			}
			else
			{
				$products[$this->request->getArgument('productId')] = $this->request->getArgument('productName');
			}
		}

		$GLOBALS['TSFE']->fe_user->setKey('ses', 'wishlist', $products);

		$this->view->assign('products', $products);
	}


	public function wishlistShowAction()
	{
		if($GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist'))
		{
			$products = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist');
		}
		else
		{
			$products = array();
		}

		$this->view->assign('products', $products);
	}


	public function wishlistClearAction()
	{
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'wishlist', '');

		$this->view->assign('products', $products);
	}
}