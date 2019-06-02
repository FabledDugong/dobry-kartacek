'use strict'

//------------------------------------------------------------------------------------------------------
function Notification ( msg, type = '#666', duration = 3000 )
{
    const   el = document.createElement( 'div' ),
            h3 = document.createElement( 'h3' ),
            tn = document.createTextNode( msg );

    h3.appendChild( tn );
    el.appendChild( h3 );
    el.style.background = type;;
    el.id = 'notification';
    document.body.appendChild( el );

    setTimeout( () => {

        el.classList.add( 'visible' );

        setTimeout( () => {

            el.classList.remove( 'visible' );
            setTimeout( () => { el.parentNode.removeChild( el ); }, 500 );

        }, duration );
    }, 500 );
}
//------------------------------------------------------------------------------------------------------
function AddEvent ( el, ev, cb )
{
    switch ( Object.prototype.toString.call( el ).slice( 8, -1 ).toLowerCase() ) {

        case 'string' :
        {
            document.querySelector( el ).addEventListener( ev, cb );
            break;
        }

        case 'htmlcollection' :
        {
            for ( let e of el )
                e.addEventListener( ev, cb );
            break;
        }

        default :
        {
            el.addEventListener( ev, cb )
            break;
        }
    }
}
//------------------------------------------------------------------------------------------------------
function Ajax ( url, type = 'GET', data = {} )
{
    const loader = document.createElement( 'div' );
    loader.id = 'loading';
    loader.style.borderColor = '#52c234';

    document.body.appendChild( loader );

    return new Promise( ( resolve, reject ) =>
    {
        const xhr = new XMLHttpRequest();
        let args = '';

        xhr.onreadystatechange = () =>
        {
            if ( xhr.readyState === 1 )
                setTimeout( () => { loader.style.opacity = 1; }, 50 );

            if ( xhr.readyState === 4 )
            {
                loader.style.opacity = 0;
                loader.ontransitionend = () => { loader.parentNode.removeChild( loader ); }

                if ( xhr.status === 200 )
                    resolve( JSON.parse( xhr.responseText ) );
                else
                    reject( xhr.statusText );
            }
        }

        xhr.open( type, url, true );

        if ( type === 'POST' )
        {
            xhr.setRequestHeader( 'X-Requested-With', 'XMLHttpRequest' );
            xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
        }

        for ( let key in data )
            args += ( key + '=' + data[key] + '&' );

        xhr.send( args.slice( 0, -1 ) );
    });
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

//------------------------------------------------------------------------------------------------------
function Carousel ( identificator, urls )
{
    if ( !(this instanceof Carousel) )
        return new Carousel( target, urls );

    this.TARGET = document.querySelector( identificator );
    this.ACTIVE = 0;
    this.IMGS = {
        urls: urls
    };

    this.init();
}

Carousel.prototype.init = function ()
{
    // creating <img>
    this.IMGS.wrapper = document.createElement( 'div' );
    this.IMGS.html = {
        prev: document.createElement( 'img' ),
        curr: document.createElement( 'img' ),
        next: document.createElement( 'img' )
    };

    this.IMGS.wrapper.classList.add( 'images' );
    this.IMGS.wrapper.addEventListener( 'transitionend', this.swap.bind(this) );

    this.swap();

    for ( const i in this.IMGS.html )
        this.IMGS.wrapper.appendChild( this.IMGS.html[i] );

    this.TARGET.appendChild( this.IMGS.wrapper );

    // creating controls
    const controls = {
        wrapper: document.createElement( 'div' ),
        prev: document.createElement( 'div' ),
        next: document.createElement( 'div' )
    };

    controls.prev.classList.add( 'prev' );
    controls.prev.addEventListener( 'click', this.prev.bind(this) );
    controls.next.classList.add( 'next' );
    controls.next.addEventListener( 'click', this.next.bind(this) );
    controls.wrapper.classList.add( 'controls' );
    controls.wrapper.appendChild( controls.prev );
    controls.wrapper.appendChild( controls.next );

    this.TARGET.appendChild( controls.wrapper );
}

Carousel.prototype.swap = function ()
{
    this.TARGET.style.pointerEvents = 'none';
    this.IMGS.wrapper.style.transitionDuration = '0s';

    let prev = this.ACTIVE - 1,
        next = this.ACTIVE + 1;

    if ( prev < 0 )
        prev = this.IMGS.urls.length - 1;

    if ( next > this.IMGS.urls.length - 1 )
        next = 0;

    this.IMGS.html.prev.src = this.IMGS.urls[prev];
    this.IMGS.html.curr.src = this.IMGS.urls[this.ACTIVE];
    this.IMGS.html.next.src = this.IMGS.urls[next];

    this.IMGS.wrapper.style.top = 0;
    setTimeout( () => {
        this.TARGET.style.pointerEvents = 'all';
        this.IMGS.wrapper.style.transitionDuration = '.5s';
    }, 200 );
}

Carousel.prototype.prev = function ()
{
    this.ACTIVE = ( this.ACTIVE === 0 ) ? this.IMGS.urls.length - 1 : this.ACTIVE - 1;
    this.TARGET.style.pointerEvents = 'none';
    this.IMGS.wrapper.style.top = this.IMGS.wrapper.clientHeight + 'px';
}

Carousel.prototype.next = function ()
{
    this.ACTIVE = ( this.ACTIVE === this.IMGS.urls.length - 1 ) ? 0 : this.ACTIVE + 1;
    this.TARGET.style.pointerEvents = 'none';
    this.IMGS.wrapper.style.top = '-' + this.IMGS.wrapper.clientHeight + 'px';
}

/*

  ***************************************
    GENERAL USE OF carousel
  ***************************************

const _carousel = new Carousel (
    '#main',
    [
        'https://images.unsplash.com/photo-1558920227-d4baa14b271c?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
        'https://images.unsplash.com/photo-1557897467-d59fb33eb834?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
    ]
);

 */