
    
<?php if(function_exists('pagenavi')) { pagenavi(); } ?>
  </div><!-- /#wrap -->
  <?php roots_footer_before(); ?>
    <div id="footerbg">
        <div class="container">
    <div class="span4"> <?php roots_footer_inside(); ?>
      <?php dynamic_sidebar('roots-footer'); ?></div>
    <div class="span4">
    <div class="fb-like-box" data-href="http://www.facebook.com/TrueArtists" data-width:300px; data-show-faces="true" data-stream="false" data-header="true"></div>
    </div>
    <div class="span4">
    <footer id="content-info">
     <h3>Get in touch with us</h3>
      <address><a href="mailto:contact@trueartists.com">contact@trueartists.com</a>
      +(123) - 456 - 7890</address>
      <p class="copy">&copy; <?php echo date('Y'); ?> TrueArtists Blog. All rights reserved.</p>
    </footer></div>
    </div>


    
    </div>
    <?php roots_footer_after(); ?>
</div>
  <?php wp_footer(); ?>
  <?php roots_footer(); ?>
<script type="text/javascript">
/*
$(window).resize(function() {
  var computed_width = $('#wrap').width();
  if (computed_width>=1170)
  {
  $('div.fb-like-box iframe').attr('style', 'width: 370px')
  $('#uhosvd_1').attr('style', 'width: 370px')
  }
else if (computed_width < 1170 && computed_width >= 980)
{
		$('div.fb-like-box iframe').attr('style', 'width: 300px')
		$('#uhosvd_1').attr('style', 'width: 370px')
}
else if (computed_width < 980 && computed_width >= 768)
{
		$('div.fb-like-box iframe').attr('style', 'width: 300px')
		$('#uhosvd_1').attr('style', 'width: 370px')
}
else if (computed_width < 768 && computed_width >= 480)
{
		$('div.fb-like-box iframe').attr('style', 'width: 300px')
		$('#uhosvd_1').attr('style', 'width: 370px')
}
});
*/



/* PIN */
(function() {
    window.PinIt = window.PinIt || { loaded:false };
    if (window.PinIt.loaded) return;
    window.PinIt.loaded = true;
    function async_load(){
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.async = true;
        if (window.location.protocol == "https:")
            s.src = "https://assets.pinterest.com/js/pinit.js";
        else
            s.src = "http://assets.pinterest.com/js/pinit.js";
        var x = document.getElementsByTagName("script")[0];
        x.parentNode.insertBefore(s, x);
    }
    if (window.attachEvent)
        window.attachEvent("onload", async_load);
    else
        window.addEventListener("load", async_load, false);
})();
/* END PIN */

$('#wp_bannerize-2').addClass('clearfix');

$('.specialwidgetpopular').addClass('active');
$('.popular').fadeIn(100);

 $('.specialwidgetrecent a').click(function () {
 				 $('.popular').css({'display':'none'});
 				 $('.specialwidgetpopular').removeClass('active');
 				  $('.comments').css({'display':'none'});
 				 $('.specialwidgetcomments').removeClass('active');
 				  $('.tags').css({'display':'none'});
 				 $('.specialwidgettags').removeClass('active');
 			$('.specialwidgetrecent').addClass('active');
            $('.recent').fadeIn(500);
            return false;
        }); 
 $('.specialwidgetcomments a').click(function () {
 				 $('.popular').css({'display':'none'});
 				 $('.specialwidgetpopular').removeClass('active');
 				  $('.recent').css({'display':'none'});
 				 $('.specialwidgetrecent').removeClass('active');
 				  $('.tags').css({'display':'none'});
 				 $('.specialwidgettags').removeClass('active');
 			$('.specialwidgetcomments').addClass('active');
            $('.comments').fadeIn(500);
            return false;
        }); 
  $('.specialwidgettags a').click(function () {
 				 $('.popular').css({'display':'none'});
 				 $('.specialwidgetpopular').removeClass('active');
 				  $('.comments').css({'display':'none'});
 				 $('.specialwidgetcomments').removeClass('active');
 				  $('.recent').css({'display':'none'});
 				 $('.specialwidgetrecent').removeClass('active');
 			$('.specialwidgettags').addClass('active');
            $('.tags').fadeIn(500);
            return false;
        }); 
   $('.specialwidgetpopular a').click(function () {
 				 $('.recent').css({'display':'none'});
 				 $('.specialwidgetrecent').removeClass('active');
 				  $('.comments').css({'display':'none'});
 				 $('.specialwidgetcomments').removeClass('active');
 				  $('.tags').css({'display':'none'});
 				 $('.specialwidgettags').removeClass('active');
 			$('.specialwidgetpopular').addClass('active');
            $('.popular').fadeIn(500);
            return false;
        }); 
</script>
</body>
</html>