$(function(){
		 $("#menu a").mouseover(function(){
										var menu = $(this).parent().children('.submenu'); 
										var submenu = $(this).parent().parent();
									// Abre o sub-menu
										if(menu.length > 0 && menu.is(':hidden')){
											$(".submenu").slideUp();
											menu.slideDown();
										 }
										 if(!submenu.hasClass('submenu') && menu.length == 0){
											 $(".submenu").slideUp();
											 }
										 })		   
		   })