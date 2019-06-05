'use strict'

const   _tabs = [ ...document.querySelectorAll('#profile-control #menu .tab')],
        _content = [ ...document.querySelectorAll('#profile-content section')]

_tabs.map( e => e.addEventListener('click', () => {

    for ( let c of _content )
        ( e.dataset.target === c.id )
            ? c.style.display = 'flex'
            : c.style.display = 'none'

    for ( let t of _tabs )
        ( t === e )
            ? t.classList.add('active')
            : t.classList.remove('active')

} ) )