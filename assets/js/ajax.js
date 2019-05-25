'use strict'

function Ajax ( url, type = 'GET', data = {} ) {

    const loader = document.createElement( 'div' )
    loader.id = 'loading'
    loader.style.borderColor = '#52c234'

    document.body.appendChild( loader )

    return new Promise( ( resolve, reject ) => {

        const xhr = new XMLHttpRequest()
        let args = ''

        xhr.onreadystatechange = () => {

            if ( xhr.readyState === 1 )
                setTimeout( () => {

                    loader.style.opacity = 1

                }, 50 )

            if ( xhr.readyState === 4 ) {

                loader.style.opacity = 0
                loader.ontransitionend = () => {

                    loader.parentNode.removeChild( loader )

                }

                if ( xhr.status === 200 )
                    resolve( JSON.parse( xhr.responseText ) )
                else
                    reject( xhr.statusText )

            }

        }

        xhr.open( type, url, true )

        if ( type === 'POST' ) {

            xhr.setRequestHeader( 'X-Requested-With', 'XMLHttpRequest' )
            xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' )

        }

        for ( let key in data )
            args += ( key + '=' + data[key] + '&' )

        xhr.send( args.slice( 0, -1 ) )

    } )

}


/*

  ***************************************
    GENERAL USE OF handlers WITH Ajax
  ***************************************

window.addEventListener('DOMContentLoaded', () => {

    AddEvent( '#btn', 'click', () => {

        Ajax( 'load.php' ).then( ( data ) => {

            for ( const m of data ) {

                const p = document.createElement( 'p' )
                p.innerHTML = m.name
                document.body.appendChild( p )

            }

        } ).catch( ( err ) => {

            Notification( String.prototype.toUpperCase.call( err ), '#dc3545' )

        } )

    });

})


 */