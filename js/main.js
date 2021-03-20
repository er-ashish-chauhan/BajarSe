// increasing descresing product qty

 
	var x = $('.qtyProduct').val();

  $(document).on('click', '.plus', function(){
    
      x++
      $(this).parent().find('.qtyProduct').val(x);
  });

   $(document).on('click', '.minus', function(){
     
      $(this).parent().find('.qtyProduct').val(x);
        if(x>1){
        x--
        $(this).parent().find('.qtyProduct').val(x);
      }
  })
  	




  	$('.goShop').click(function(){
  		$('#storesList').hide();
  		$('#ShopSection').show();
  	})

    $('.goOfferDetail').click(function(){
      $('#offersSection').hide();
      $('#OfferdetailSection').show();
      $('#ShopSection').hide();
    })

    $('#backOfferTab').click(function(){
      $('#offersSection').show();
      $('#OfferdetailSection').hide();
      $('#ShopSection').show();
    })



    $('.gocatalogDetail').click(function(){
      $('#catalogSection').hide();
      $('#catalogdetailSection').show();
      $('#ShopSection').hide();

    })

    $('#backCatelogTab').click(function(){
      $('#catalogSection').show();
      $('#catalogdetailSection').hide();
      $('#ShopSection').show();

    })

    




    $('.goToOrders').click(function(){
      $('#ordersList').hide();
      $('#OrderdetailSection').show();
    })

    $('#backOrdersList').click(function(){
      $('#ordersList').show();
      $('#OrderdetailSection').hide();
    })

    




    $('#OffersCoupons').click(function(){
      $('#cartSection').hide();
      $('#offersCouponSection').show();

    })


    $('#ViewAdditionalbtn').click(function(){
        $('#ViewAdditionalProducts').toggle();
    })

    $('#goProfile').click(function(){
        $('#menuList').hide();
        $('#profileSection').show();
    })

    $('#backProfile').click(function(){
        $('#menuList').show();
        $('#profileSection').hide();
    })



    $('#goSupport').click(function(){
        $('#menuList').hide();
        $('#supportSection').show();
    })

     $('#backSupport').click(function(){
        $('#menuList').show();
        $('#supportSection').hide();
    })

    $('#goHTU').click(function(){
        $('#menuList').hide();
        $('#htuSection').show();
    })

    $('#backHTU').click(function(){
        $('#menuList').show();
        $('#htuSection').hide();
    })

    $('.goProductDetail').click(function(){
        $('#ShopSection').hide();
        $('#productDetailSection').show();
    })

     $('#backProductTab').click(function(){
        $('#ShopSection').show();
        $('#productDetailSection').hide();
    });


     $('.goAddNewAddress').click(function(){
      $('#cartSection').hide();
       $('#addNewAddressSection').show();
     });

     $('.backCartSection').click(function(){
       $('#cartSection').show();
       $('#addNewAddressSection').hide();
     });

      $('#backstoreList').click(function(){
        $('#ShopSection').hide();
        $('#storesList').show();
    })


     //  $('#addMoreAddress').click(function(){
     //    $('#addNewAddressSection').show();
     //    $('#menuPage').hide();
        
     // })



     




    // go back functionality

    

   


  	$('.addQty').click(function(){
      
  		$(this).hide();
  		$(this).parent().find('.increase-product').show();
  	})
   

   $('.goNCD').click(function(){
      
      $('#cartSection').hide();
      $('#noContactDelivery').show();
    })

   $('#backNCD').click(function(){
      $('#cartSection').show();
      $('#noContactDelivery').hide();
    })
    

    


    $(window).scroll(function(){
      var pageHeader = $('#pageHeader');
      var scroll = $(window).scrollTop();
      if(scroll >= 200) pageHeader.addClass('header-fixed');
      else pageHeader.removeClass('header-fixed');

    })


    $(window).scroll(function(){
      var pageHeaderShop = $('#pageHeaderShop');
      var scroll = $(window).scrollTop();
      if(scroll >= 50) pageHeaderShop.addClass('header-fixed');
      else pageHeaderShop.removeClass('header-fixed');

    })


    $('.applyCode').click(function(){

      $('.applyCode').attr('src', 'img/applycode_icon_unselect.svg' )
      
      if($(this).attr('src') == 'img/applycode_icon_unselect.svg'){
         $(this).attr('src', 'img/applycode_icon_select.svg');
      }

      else{
         $(this).attr('src', 'img/applycode_icon_unselect.svg');
      }
      
    })


   $('.choosePayment').click(function(){
    
     $('.choosePayment').attr('src', 'img/check.svg');
     $('.deleteChoosed').attr('src', 'img/delete.svg');
     if($(this).attr('src')=='img/check.svg'){
         $(this).attr('src', 'img/checked.svg');
         $(this).next('.deleteChoosed').attr('src', 'img/delete_checked.svg')
     }

     else{
         $(this).attr('src', 'img/check.svg');
     }


   })


 


   $(document).on('click', '.likeThis', function(){
    
     if($(this).attr('src')=='img/like_blank.svg'){
        
        $(this).attr('src', 'img/liked.svg');
     }

     else{
       $(this).attr('src', 'img/like_blank.svg');
     }

   })


   $('#checkcontainer').on('click change', function(e){
   e.stopPropagation(); 
});


   $(document).on('click', '.removeNotification', function(){
      $(this).parent().cloasest('.notification-box').hide();
   });

    $(document).on('click', '.showqtyBox', function(){
      $(this).hide();
      $(this).next('.qtyBox').show();
   });















