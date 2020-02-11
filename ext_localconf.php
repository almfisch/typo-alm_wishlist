<?php
defined('TYPO3_MODE') || die();

call_user_func(function()
{
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Alm.alm_wishlist',
        'Ajax',
        array(
            'Ajax' => 'wishlistAdd, wishlistRemove, wishlistUpdate, wishlistShow, wishlistClear',
        ),
        array(
            'Ajax' => 'wishlistAdd, wishlistRemove, wishlistUpdate, wishlistShow, wishlistClear',
        )
    );

    if(TYPO3_MODE === 'FE')
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterInitializeCurrentPage'][] = \Alm\AlmWishlist\Hooks\FormHooks::class;
    }
});
