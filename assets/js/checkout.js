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

const   _tabs = [...document.getElementsByClassName('tab')],
        _tabs_control = [...document.querySelectorAll('#progress a')]

    _tabs_control.map( e => e.addEventListener('click', () => {

        ((tab) => {
            _tabs.forEach(el => {
                if (el.dataset.tab === tab)
                    el.classList.add('active')
                else
                    el.classList.remove('active')
            })
        })(e.dataset.tab)


        // _tabs.forEach(el => {
        //     if (el.classList.contains('active')) {
        //         el.classList.toggle('active')
        //     } else
        //         el.classList.toggle('active')
        // })
    }))


console.log(_tabs_control)
