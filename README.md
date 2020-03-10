# Alm WishList
Alm WishList let you save Items in a Cookie and append to a TYPO3-Standard-Form.

## Installation
- Install Extension
- Include Static Template
- Adjust Typoscript
- Add cObject to Fluid-Page-Template
- Add data-url to your Item-Image

## Typoscript Settings
```
plugin.tx_almwishlist {
	settings {
		typeNumAjax = 768357			// TypeNum for AjaxPage
		formPageUid = 1					// Page UID of Form-Element
		formIdentifier = inquiry_form	// Form-Identifier of TYPO3-Form-Element
		formListBeforeElement = end		// end or Number of Element to append
	}
}
```

```
plugin.tx_yourtheme {
	settings.wishlist < plugin.tx_almwishlist.settings
}
```

```
WISHLIST = USER
WISHLIST {
	userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
	extensionName = AlmWishlist
	vendorName = Alm
	pluginName = Ajax
	switchableControllerActions {
		Ajax {
			1 = wishlistShow
			2 = wishlistClear
		}
	}
}
```

## Template Settings
```
PageTemplate:

<f:cObject typoscriptObjectPath="lib.theme.WISHLIST" />
```

```
ProduktTemplate:

<div class="theme_productdetail_btn">
	<button type="button" class="btn btn-sm btn-primary btn_wishlist"
		data-url="{f:uri.action(
			extensionName: 'AlmWishlist',
			controller: 'Ajax',
			pluginName: 'Ajax',
			action: 'wishlistAdd',
			pageType: '{settings.wishlist.typeNumAjax}',
			arguments: {productId: '{resource.uid}',
			productName: '{page.title} - {resource.title}'}
		)}">
		Merkliste <i class="fas fa-plus-circle"></i>
	</button>
</div>
```

## SiteConfig (V9)
```
Add typeNumAjax to SiteConfig because it will be ignored if empty.

PageTypeSuffix:
  map:
    'twl': 768357
```

## License
![License GPL](https://img.shields.io/badge/License-GPL-blue?style=flat-square)

Read the LICENSE.md