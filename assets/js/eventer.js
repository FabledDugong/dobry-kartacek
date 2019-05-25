'use strict'

function AddEvent ( el, ev, cb ) {

    switch ( Object.prototype.toString.call( el ).slice( 8, -1 ).toLowerCase() ) {

        case 'string' : {

            document.querySelector( el ).addEventListener( ev, cb )
            break;

        }

        case 'htmlcollection' : {

            for ( let e of el )
                e.addEventListener( ev, cb )

            break;

        }

        default : {

            el.addEventListener( ev, cb )
            break;

        }

    }

}