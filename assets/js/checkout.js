'use strict'

let _delete = [...document.getElementsByClassName('delete')]
// _destroy = document.getElementById('destroy')
// _destroy.addEventListener('click', () => {
//     const xhr = new XMLHttpRequest()
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200)
//             console.log('success')
//     }
//
//     xhr.open('GET', 'delShoppingCart.php', true)
//     xhr.send()
//
//     location.reload()
// })

_delete.map(el => el.addEventListener('click', () => {
    const xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
            console.log('success')
    }

    xhr.open('POST', 'sc_DeleteProduct.php', true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhr.send(`id=${el.dataset.id}`)

    location.reload()
}))

/* tabs */
const   _tabs = [ ...document.querySelectorAll( '#checkout #checkout-control .tab' ) ],
        _content = [ ...document.querySelectorAll( '#checkout #checkout-content .tab-content' ) ]

_tabs.map( e => e.addEventListener( 'click', () => {

    for ( let c of _content )
        ( e.dataset.target === c.id )
            ? c.style.display = 'flex'
            : c.style.display = 'none'

    for ( let t of _tabs )
        ( t === e )
            ? t.classList.add('active')
            : t.classList.remove('active')

} ) )
