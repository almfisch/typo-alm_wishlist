$(document).ready(function(){
    formInit();
    ajaxInit(true);
    

	//* Start: AjaxInit *//
	function ajaxInit(initAll)
	{
		var myButtons;

		if(initAll == true)
		{
			myButtons = '.theme_productdetail .btn_wishlist, .wishlist_products .btn_wishlist, .ce_form .btn_wishlist';
		}
		else
		{
			myButtons = '.wishlist_products .btn_wishlist';
        }

		$(myButtons).each(function(){
			$(this).on('click', function(e){
				//e.preventDefault();

                var object = $(this);
                var action = object.data('url');
                var myClass;

                $.ajax({
                    url: action,
                    dataType: 'text',
                    type: 'POST',
                    cache: false,
                    beforeSend: function(){
                    	myClass = object.find('i').attr('class');
                    	object.find('i').removeAttr('class');
                        object.find('i').addClass('fas fa-spinner fa-spin');
                    },
                    success: function(data){
                    	object.find('i').removeAttr('class');
                    	object.find('i').addClass(myClass);
                    	//object.find('i').addClass('fas fa-check-circle');
                        $('.wishlist_products').replaceWith(data);

                        ajaxInit();
                        
                        if($('.ce_form .wishlist_wrapper').length)
                        {
                            location.reload();
                        }

						/*
                    	var found = 0;
						$.each(data, function(key, value){
							$('.wishlist_products').append('<div class="wishlist_product">' + value + '</div>');

							if(value == object.data('product'))
                    	    {
                                found++;
                            }
						});

						if(found > 0)
                    	{
                            //object.find('i').addClass('fas fa-minus-circle');
                            object.find('i').addClass(myClass);
                        }
                        else
                        {
                            object.find('i').addClass(myClass);
                        }
                        */
                    },
                    error: function(){
                    	object.find('i').removeAttr('class');
                        object.find('i').addClass(myClass);
                    },
                 });
			});
		});


		$('.btn_wishlist_clear').on('click', function(e){
            //e.preventDefault();

            var object = $(this);
            var action = object.data('url');
            var myHtml;

            $.ajax({
                url: action,
                dataType: 'text',
                type: 'POST',
                cache: false,
                beforeSend: function(){
                    myHtml = object.html();
                    object.html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(data){
                    myHtml = object.html(myHtml);

                    $('.wishlist_products').replaceWith(data);

                    if($('.ce_form .wishlist_wrapper').length)
                    {
                        location.reload();
                    }
                },
                error: function(){
                     myHtml = object.html(myHtml);
                },
             });
        });
    }
    
    //* Start: FormInit *//
	function formInit()
	{
        var myProducts = [];

        $('.wishlist_products .wishlist_table .wishlist_product').each(function(){
            var product = [];

            product['id'] = $(this).find('.btn_wishlist').data('productid');
            product['url'] = $(this).find('.btn_wishlist').data('url');
            
            myProducts.push(product);
        });


        myProducts.forEach(function(item, index){
            $('.ce_form .wishlist_wrapper .wishlist_item_' + item['id'] + ' > legend').prepend('<span class="btn_wishlist"><i class="fas fa-minus-circle"></i></span>');
            $('.ce_form .wishlist_wrapper .wishlist_item_' + item['id'] + ' > legend .btn_wishlist').attr('data-url', item['url']);
            //$('.ce_form .wishlist_wrapper .wishlist_item_' + item['id'] + ' > legend .btn_wishlist').data('url', item['url']);
            /*
            $('.ce_form .wishlist_wrapper .wishlist_item_' + item['id'] + ' > legend .btn_wishlist').on('click', function(){
                $(this).find('i').removeAttr('class');
                $(this).find('i').addClass('fas fa-spinner fa-spin');
                $('.wishlist_products .wishlist_table .wishlist_product_' + item['id'] + ' .btn_wishlist').trigger('click');
            });
            */
        });
    }
});
