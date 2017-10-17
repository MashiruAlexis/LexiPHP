var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
window.onload = function(){
	
		/* Prepare gallery items to work with Materialbox */
		$( "#gallery .material-placeholder" ).wrap( "<div></div>" );
		/* Initialize gallery */
		$('#gallery').justifiedGallery({
			lastRow : 'justify',
			margins : 5
		});
		
	/* Hide Preloader */
	$('.preloader-wrapper').css({ display: "none" });
	
	/* Fade to page */
	$('.stage').velocity({ opacity: 0 }, 1000, function() { 
		$('body').removeClass('loading');
	});