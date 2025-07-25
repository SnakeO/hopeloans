jQuery(function($)
{
	$('.header-pc .btn-nav').click(function(e){
		e.preventDefault();
		$(this).parents('#header').toggleClass('open-pc');
	})
	$('.header-mobile .btn-nav').click(function(e){
		e.preventDefault();
		if( $(this).parents('#header').hasClass('open-pc') ) $(this).parents('#header').toggleClass('open-pc');
		else $(this).parents('#header').toggleClass('open');
	})
	$('#header .header-mobile .hh_mobilenav ul li.menu-item-has-children > a').click(function(e){
		e.preventDefault();
		$(this).parent('li').toggleClass('open');
	})
})