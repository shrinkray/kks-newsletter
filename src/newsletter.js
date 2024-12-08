import './newsletter.scss';

// Keyboard navigation support
document.querySelectorAll( '.news-links a' ).forEach( ( link ) => {
	link.addEventListener( 'keydown', ( e ) => {
		if ( e.key === 'Enter' || e.key === ' ' ) {
			e.preventDefault();
			link.click();
		}
	} );
} );
