$(function(){
	$('div.navigation ul li').hover(function(){
		$(this).find('a').stop().animate({width:'350px'},{queue:false, duration:400, easing: 'jswing'});
	},function(){
		$(this).find('a').stop().animate({width:'0px'},{queue:false, duration:400, easing: 'jswing'});
	});
});
