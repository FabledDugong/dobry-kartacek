'use strict'

const   _menu = [... document.querySelectorAll('#navigation div > ul > li')]
        // _content = [ ...document.querySelectorAll( 'section' ) ]

_menu.map( e => e.addEventListener('click', () => {

    // for ( let c of _content )
    //     ( e.dataset.target === c.id )
    //         ? c.style.display = 'flex'
    //         : c.style.display = 'none'

    for ( let m of _menu )
        ( m === e )
            ? m.classList.add('active')
            : m.classList.remove('active')

}))