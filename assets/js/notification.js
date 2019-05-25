'use strict'

function Notification ( msg, type = '#666', duration = 3000 ) {

    const el = document.createElement( 'div' ),
        h3 = document.createElement( 'h3' ),
        tn = document.createTextNode( msg )

    h3.appendChild( tn )
    el.appendChild( h3 )
    el.style.background = type;
    el.id = 'notification'
    document.body.appendChild( el )

    setTimeout( () => {

        el.classList.add( 'visible' )

        setTimeout( () => {

            el.classList.remove( 'visible' )

            setTimeout( () => {

                el.parentNode.removeChild( el )

            }, 500 )

        }, duration )

    }, 500 )

}