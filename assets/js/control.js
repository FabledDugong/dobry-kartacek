'use strict'

const   _menu = [... document.querySelectorAll('#navigation div > ul > li')]

_menu.map( e => e.addEventListener('click', () => {

    for ( let m of _menu )
        ( m === e )
           ? m.classList.add('active')
           : m.classList.remove('active')

}))