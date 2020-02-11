<?php
declare(strict_types=1);
namespace Alm\AlmWishlist\Hooks;

/* Version (but not working) with \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface
public function afterInitializeCurrentPage(\TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $currentPage = null, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $lastPage = null, array $requestArguments = []): \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface
*/

class FormHooks
{
	/**
	 * @param \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime
     * @param null|\TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $currentPage
     * @param null|\TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $lastPage
     * @param mixed $elementValue submitted value of the element *before post processing*
     * @return null|\TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface
     */
    public function afterInitializeCurrentPage(\TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $currentPage = null, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $lastPage = null, array $requestArguments = [])
	{
    	$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
		$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $settings['plugin.']['tx_almwishlist.']['settings.'];


        if(!$lastPage)
        {
            $actPage = $currentPage;
        }
        else
        {
            $actPage = $lastPage;
        }

        if($actPage->getParentRenderable()->getIdentifier() == $settings['formIdentifier'])
        {
            if($GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist'))
            {
                $products = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wishlist');

                if($settings['formListBeforeElement'] != 'end' && ctype_digit($settings['formListBeforeElement']))
                {
                    $pageElements = $actPage->getElements();
                    $beforeElement = $pageElements[intval($settings['formListBeforeElement'])];
                }

                $fieldsetProducts = $actPage->createElement('wishlist_wrapper', 'Fieldset');
                $fieldsetProducts->setLabel(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('form.headline', 'alm_wishlist'));
                $fieldsetProducts->setOptions(array('properties' => array('elementClassAttribute' => 'wishlist_wrapper')));

                foreach($products as $key => $value)
                {
                    $fieldset = $fieldsetProducts->createElement('wishlist_item_wrapper_' . $key, 'Fieldset');
                    $fieldset->setLabel($value);
                    $fieldset->setOptions(array('properties' => array('elementClassAttribute' => 'wishlist_item_wrapper wishlist_item_' . $key)));

                    $element = $fieldset->createElement('wishlist_item_name_' . $key, 'Text');
                    $element->setDefaultValue($value);
                    $element->setOptions(array('properties' => array('containerClassAttribute' => 'wishlist_item_name')));

                    $gridRow = $fieldset->createElement('wishlist_gridrow_' . $key, 'GridRow');
                    $gridRow->setOptions(array('properties' => array('elementClassAttribute' => 'row wishlist_row')));

                    $element = $gridRow->createElement('wishlist_item_' . $key, 'Text');
                    //$element->setLabel($value);
                    $element->setDefaultValue('1');
                    $element->setOptions(array('properties' => array(
                            'elementClassAttribute' => 'wishlist_item_count',
                            'gridColumnClassAutoConfiguration' => array(
                                'viewPorts' => array(
                                    'lg' => array('numbersOfColumnsToUse' => 1),
                                    'md' => array('numbersOfColumnsToUse' => 1),
                                    'sm' => array('numbersOfColumnsToUse' => 2),
                                    'xs' => array('numbersOfColumnsToUse' => 12),
                                ),
                            ),
                        ),
                    ));
                    //$element->addValidator(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class)->get(\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class));

                    $element = $gridRow->createElement('wishlist_item_comment_' . $key, 'Textarea');
                    //$element->setLabel(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('form.comment', 'alm_wishlist'));
                    $element->setOptions(array('properties' => array(
                            'elementClassAttribute' => 'wishlist_item_comment',
                            'placeholder' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('form.comment', 'alm_wishlist'),
                            'gridColumnClassAutoConfiguration' => array(
                                'viewPorts' => array(
                                    'lg' => array('numbersOfColumnsToUse' => 11),
                                    'md' => array('numbersOfColumnsToUse' => 11),
                                    'sm' => array('numbersOfColumnsToUse' => 10),
                                    'xs' => array('numbersOfColumnsToUse' => 12),
                                ),
                            ),
                        ),
                    ));

                    if($beforeElement)
                    {
                        $actPage->moveElementBefore($fieldsetProducts, $beforeElement);
                    }
                }
            }
        }

        if(!$lastPage)
        {
            $currentPage = $actPage;
        }
        else
        {
            $lastPage = $actPage;

            $GLOBALS['TSFE']->fe_user->setKey('ses', 'wishlist', '');
        }

		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($currentPage);

    	return $currentPage;
    }
}