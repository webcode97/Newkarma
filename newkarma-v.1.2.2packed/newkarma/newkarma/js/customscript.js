/**
 * Copyright (c) 2021 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package Newkarma
 */

(function(sidr) {
	"use strict";

	sidr.new('#gmr-topnavresponsive-menu', {
		name: 'topnavmenus',
		source: '.gmr-mobilelogo, .close-topnavmenu-wrap, .gmr-search, .gmr-mainmenu, .gmr-topnavmenu, .gmr-secondmenuwrap',
		displace: false,
		onOpen   : function( name ) {
			// Re-name font Icons to correct classnames and support menu icon plugins.
			var elems = document.querySelectorAll( "[class*='sidr-class-icon_'], [class*='sidr-class-_mi']" ), i;
			for ( i = 0; i < elems.length; i++ ) {
				var elm = elems[i];
				if ( elm.className ) {
					elm.className = elm.className.replace(/sidr-class-/g,'');
				}
			}
		}
	});

	document.querySelector( '#sidr-id-close-topnavmenu-button' ).addEventListener(
		'click',
		function( e ) {
			e.preventDefault();
			sidr.close('topnavmenus');
		}
	);

	document.querySelector( 'input#sidr-id-s' ).addEventListener(
		'click',
		function( e ) {
			e.preventDefault();
			e.stopPropagation();
		}
	);
	
	/* $( '.sidr-inner li' ).each( */
	var elmTag = document.querySelectorAll( '.sidr-inner li' ), i;
	
	for ( i = 0; i < elmTag.length; i++ ) {
		if ( elmTag[i].querySelectorAll( 'ul' ).length > 0 ) {
			var elm = elmTag[i].querySelectorAll( 'a' );
			if ( elm !== null ) {
				elm[0].innerHTML += '<span class="sub-toggle"><span class="arrow_carrot-down"></span></span>';
			}
		}
	}
	
	/* $( '.sidr-inner .sub-toggle' ).click( */
	var elmTag = document.querySelectorAll( '.sidr-inner .sub-toggle' ), i;
	
	for ( i = 0; i < elmTag.length; i++ ) {
		elmTag[i].addEventListener(
			'click',
			function( e ) {
				e.preventDefault();
				var t = this;
				t.classList.toggle( 'is-open' );
				if ( t.classList.contains( 'is-open' ) ) {
					var txt = '<span class="arrow_carrot-up"></span>';
				} else {
					var txt = '<span class="arrow_carrot-down"></span>';
				}
				t.innerHTML = txt;
				/* console.log (t.parentNode.parentNode.querySelectorAll( 'a' )[0].nextElementSibling); */
				var container = t.parentNode.parentNode.querySelectorAll( 'a' )[0].nextElementSibling;
				if ( !container.classList.contains( 'active' ) ) {
					container.classList.add('active');
				} else {
					container.classList.remove('active');
				}
			}
		);
	}

})( window.sidr );

( function() {
	"use strict";
	
	window.addEventListener(
	'scroll',
	function() {
		var elm = document.querySelector( '.top-header-second' );
		if ( document.body.scrollTop > 5 || document.documentElement.scrollTop > 5 ) {
			if ( elm !== null ) {
				elm.classList.add( 'sticky-menu' );
			}
		} else {
			if ( elm !== null ) {
				elm.classList.remove( 'sticky-menu' );
			}
		}
		var elmontop = document.querySelector( '.gmr-ontop' );
		if ( document.body.scrollTop > 85 || document.documentElement.scrollTop > 85 ) {
			if ( elmontop !== null ) {
				elmontop.style.display = 'block';
				document.querySelector( '.gmr-ontop' ).addEventListener(
					'click',
					function( e ) {
						e.preventDefault();
						window.scroll({top: 0, left: 0, behavior: 'smooth'});
					}
				);
			}
		} else {
			if ( elmontop !== null ) {
				elmontop.style.display = 'none';
			}
		}

	});
})();
