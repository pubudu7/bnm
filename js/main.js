var bnm = bnm || {};

// polyfill closest
// https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
if ( ! Element.prototype.closest ) {
	Element.prototype.closest = function( s ) {
		var el = this;

		do {
			if ( el.matches( s ) ) {
				return el;
			}

			el = el.parentElement || el.parentNode;
		} while ( el !== null && el.nodeType === 1 );

		return null;
	};
}

// polyfill forEach
// https://developer.mozilla.org/en-US/docs/Web/API/NodeList/forEach#Polyfill
if ( window.NodeList && ! NodeList.prototype.forEach ) {
	NodeList.prototype.forEach = function( callback, thisArg ) {
		var i;
		var len = this.length;

		thisArg = thisArg || window;

		for ( i = 0; i < len; i++ ) {
			callback.call( thisArg, this[ i ], i, this );
		}
	};
}

/**
 * Menu keyboard navigation
 */
bnm.menuAccessKeyboard = {

	init: function() {
		this.focusMenuWithChildren();
	},

	// The focusMenuWithChildren() function implements Keyboard Navigation in the Primary Menu
	// by adding the '.focus' class to all 'li.menu-item-has-children' when the focus is on the 'a' element.
	focusMenuWithChildren: function() {
		// Get all the link elements within the primary menu.
		var links, i, len,
			menus = document.querySelectorAll( '.bnm-menu' );

		if ( ! menus.length ) {
			return false;
		}

        menus.forEach( function( menu ) {
            
            links = menu.getElementsByTagName( 'a' );

            // Each time a menu link is focused or blurred, toggle focus.
            for ( i = 0, len = links.length; i < len; i++ ) {
                links[i].addEventListener( 'focus', toggleFocus, true );
                links[i].addEventListener( 'blur', toggleFocus, true );
            }

        } );

        // Sets or removes the .focus class on an element.
        function toggleFocus() {
            var self = this;

            // Move up through the ancestors of the current link until we hit .main-navigation.
            while ( -1 === self.className.indexOf( 'bnm-menu' ) ) {
                // On li elements toggle the class .focus.
                if ( 'li' === self.tagName.toLowerCase() ) {
                    if ( -1 !== self.className.indexOf( 'focus' ) ) {
                        self.className = self.className.replace( ' focus', '' );
                    } else {
                        self.className += ' focus';
                    }
                }
                self = self.parentElement;
            }
        }

	}
};

/**
 * Search Toggle.
 */
bnm.searchToggle = {
    init: function() {
        this.addListener();
    },

    toggle: function( element ) {
        
		var searchBoxContainer = element.parentElement,
            header              = document.getElementById( 'masthead' ),
            searchBoxContainer  = searchBoxContainer.querySelector('#bnm-search-box'),
            inputField          = searchBoxContainer.querySelector('input.search-field');

		// Toggle header search class.
		header.classList.toggle( 'hide-header-search' );

        searchBoxContainer.classList.toggle( 'active' );

		// Focus the input field if the search box is displayed.
		if( searchBoxContainer.classList.contains( 'active' ) ) {
			inputField.focus();
		}

    },

	addListener: function() {
		
		var searchButton = document.getElementById( 'bnm-search-toggle' );

		if ( ! searchButton ) {
			return false;
		}

		var self = this;
		
		searchButton.addEventListener( 'click', function() {
			self.toggle( this );
		} );

	}
};

/**
 * Slideout Sidebar
 */
bnm.slideOutSidebar = {

    init: function() {
        this.addListeners();
    },

    createOverlay: function( maskId ) {
        var mask = document.createElement( 'div' );
        mask.setAttribute( 'class', 'bnm-overlay-mask' );
        mask.setAttribute( 'id', maskId );
        document.body.appendChild( mask );
    },

    removeOverlay: function( maskId ) {
        var mask = document.getElementById( maskId );
        mask.parentNode.removeChild( mask );
    },

    addListeners: function() {
        var _doc = document,
            body = _doc.body,
            slideOutToggles = _doc.querySelectorAll( '.bnm-slideout-toggle' );

            if ( ! slideOutToggles.length ) {
                return false;
            }
            
            var slideOutSidebar = _doc.getElementById( 'bnm-slideout-sidebar' );

            if ( ! slideOutSidebar ) {
                return false;
            }

            var closeBtn = slideOutSidebar.querySelector( '.bnm-slideout-toggle' ),
            header = _doc.getElementById( 'masthead' ),
            openBtn = header.querySelector( '.bnm-slideout-toggle' ),
            self = this;

        /**
         * To do list
         * 
         * 1. add aria-expanded
         * 2. Focus open/close buttons.
         * 3. add overlay
         */
        slideOutToggles.forEach( function( button ) {
            button.addEventListener( 'click', function() {
                if ( body.classList.contains( 'slideout-opened' ) ) {
                    body.classList.remove( 'slideout-opened' );
                    openBtn.focus();
                    self.removeOverlay( 'bnm-slideout-mask' );
                } else {
                    body.classList.add( 'slideout-opened' );
                    closeBtn.focus();
                    self.createOverlay( 'bnm-slideout-mask' );
                }
            } );
        } ); 

        document.addEventListener( 'click', function( e ) {
            if ( e.target && e.target.className === 'bnm-overlay-mask' ) {

                var maskId = e.target.id;

                body.classList.remove( 'slideout-opened' );
                self.removeOverlay( maskId );
            }
        } );
    }
};

/**
 * Mobile Menu
 */
bnm.mobileMenu = {

    init: function() {
        this.addListeners();
    },

    createOverlay: function( maskId ) {
        var mask = document.createElement( 'div' );
        mask.setAttribute( 'class', 'bnm-overlay-mask' );
        mask.setAttribute( 'id', maskId );
        document.body.appendChild( mask );
    },

    removeOverlay: function( maskId ) {
        var mask = document.getElementById( maskId );
        mask.parentNode.removeChild( mask );
    },

    addListeners: function() {
        var menuToggleButtons = document.querySelectorAll( '.bnm-mobile-menu-toggle' ),
            body = document.body,
            self = this;

        /**
         * To do list
         * 
         * 1. add aria-expanded
         * 2. Focus open/close buttons.
         * 3. add overlay
         */
        menuToggleButtons.forEach( function( button ) {
            button.addEventListener( 'click', function() {
                if ( body.classList.contains( 'mobile-menu-opened' ) ) {
                    body.classList.remove( 'mobile-menu-opened' );
                    self.removeOverlay( 'bnm-mobile-menu-mask' );
                } else {
                    body.classList.add( 'mobile-menu-opened' );
                    self.createOverlay( 'bnm-mobile-menu-mask' );
                }
            } );
        } );

        document.addEventListener( 'click', function( e ) {
            if ( e.target && e.target.className === 'bnm-overlay-mask' ) {

                var maskId = e.target.id;

                body.classList.remove( 'mobile-menu-opened' );
                self.removeOverlay( maskId );
            }
        } );
    }
};

/**
 * Mobile Menu Toggles.
 */
bnm.mobileMenuToggle = {

    init: function() {
        // Do the toggle.
        this.toggle();
    },

    performToggle: function( element ) {

        var target = element.dataset.toggleTarget,
            parentNavContainer = element.closest( '.bnm-mobile-menu' );
            activeClass = 'toggled-on';

        // Get the target element.
        targetElement = parentNavContainer.querySelector(target);

        element.classList.toggle(activeClass);

        bnmToggleAttribute(element, 'aria-expanded', 'true', 'false');

        targetElement.classList.toggle(activeClass);

    },

    toggle: function() {
        var self = this;

        document.querySelectorAll('*[data-toggle-target]').forEach( function( element ) {
            element.addEventListener( 'click', function( event ) {
                event.preventDefault();
                self.performToggle( element );
            } );
        } );
    }
};

/**
 * Toggle an attribute
 */  
function bnmToggleAttribute( element, attribute, trueVal, falseVal ) {
	if ( trueVal === undefined ) {
		trueVal = true;
	}
	if ( falseVal === undefined ) {
		falseVal = false;
	}
	if ( element.getAttribute( attribute ) !== trueVal ) {
		element.setAttribute( attribute, trueVal );
	} else {
		element.setAttribute( attribute, falseVal );
	}
}

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
function bnmDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}

bnmDomReady( function() {
    bnm.menuAccessKeyboard.init();
    bnm.searchToggle.init();
    bnm.mobileMenu.init();
    bnm.mobileMenuToggle.init();
    bnm.slideOutSidebar.init();
} );