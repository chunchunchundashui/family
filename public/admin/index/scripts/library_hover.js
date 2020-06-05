/*
 * @authors 周海鸥
 * @date    2015-04-22 17:06:03
 */

 $(function(){

 	//解决ie6下hover事件

	$('.video-directory li').hover(
	  function () {
	    $(this).css('border','1px solid #7abeda');
	  },
	  function () {
	    $(this).css('border','1px solid #e2e2e2');
	  }
	)

	$('.video-total').hover(
		function(){
			$(this).find('.video-total-ico').css('backgroundPosition','0 -40px');
		},
		function(){
			$(this).find('.video-total-ico').css('backgroundPosition','0 -60px');
		}
	)


	$('.video-play-total').hover(
		function(){
			$(this).find('.video-play-total-ico').css('backgroundPosition','-22px -40px');
		},
		function(){
			$(this).find('.video-play-total-ico').css('backgroundPosition','-22px -59px');
		}
	)

 })





			