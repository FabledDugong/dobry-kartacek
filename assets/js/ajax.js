'use strict'

function loadData (url, value, callback) {
    const xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
            callback(JSON.parse(xhr.responseText))
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhr.send(`param=${value}`)
}

function notification (msg, type, duration = 3000) {
    if ( document.getElementById('notification') == undefined ) {
        let _box = document.createElement('div'),
            _txt = document.createElement('h3')

        switch (type) {
            default:
            case 'INFO':
                type = 'DE9E33'
                break;
            case 'SUCCESS':
                type = '28a745'
                break;
            case 'ERROR':
                type = 'dc3545'
                break;
        }

        _txt.innerHTML = msg
        _box.appendChild(_txt)
        _box.id = 'notification'
        _box.style.background = '#' + type

        document.body.appendChild(_box)

        setTimeout(() => { _box.classList.add('visible') }, 100)
        setTimeout(() => { document.getElementById('notification').classList.remove('visible') }, duration)
    } else {
        document.querySelector('#notification h3').innerHTML = msg
        setTimeout(() => { document.getElementById('notification').classList.add('visible') }, 100)
        setTimeout(() => { document.getElementById('notification').classList.remove('visible') }, duration)
    }
}

function bindLoadDetail () {
    let _prods = [...document.getElementsByClassName('product')]

    _prods.map(el => el.addEventListener('click', () => {
        let html = ''

        document.getElementById('product-detail').setAttribute('data-id', el.dataset.id)

        loadData('assets/php/product_LoadDetail.php', el.dataset.id, (data) => {
            document.querySelector('.product-image').setAttribute('style', 'background: url("assets/img/products/' + data['pictures'][0]['url'] + '") no-repeat center center / contain')
            document.querySelector('.product-info').innerHTML = `<div>
                                                                    <h4>${data['name']}</h4>
                                                                    <p>${data['description']}</p>
                                                                </div>
                                                                <div>
                                                                    <h5>${ (data['stock'] > 0) ? 'skladem' : 'není skladem' }</h5>
                                                                    <h5>cena: ${data['price']}</h5>
                                                                    <h5>barva: ???</h5>
                                                                </div>`

            /* multiple images */
            // html += `<div>`
            // for ( let img of data['pictures'] )
            //     html += `<img src="assets/img/products/${img['url']}" alt="${data['name']}">`;
            // html += `</div>`

            html += `<div>
                         <div>
                            <h4>${data['name']}</h4>
                            ${(data['color'] != null) ? '<h5>' + data['color'] + '</h5>' : ''}
                         </div>
                         <p>${data['description']}</p>
                     </div>
                     <div>
                         <table>
                            ${(data['toughness'] != null) ? '<tr><td><h5>tvrdost</h5></td><td><h5>' + data['toughness'] + '</h5></td></tr>' : ''}
                            <tr>
                                <td><h5>skladem</h5></td>
                                <td><h6 style='color: ${ (data['stock'] > 0) ? '#52c234' : '#DD3B4E' }'>${ (data['stock'] > 0) ? 'ano' : 'ne' }</h6></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td><h5>cena bez dph</h5></td>
                                <td><h6><mark>${data['price']-((data['price']/100)*21)}</mark> Kč</h6></td>
                            </tr>                   
                            <tr>
                                <td><h5>cena</h5></td>
                                <td><h6><mark>${data['price']}</mark> Kč</h6></td>
                            </tr>      
                         </table>
                     </div>`

            document.querySelector('.product-info').innerHTML = html
            document.getElementById('products').style.display = 'none'
            document.getElementById('product-detail').style.display = 'flex'
        })
    }))
}

window.addEventListener('DOMContentLoaded', () => {
    bindLoadDetail()

    // ---------------------------------

    let _cats = [...document.querySelectorAll('.category > div:not(.subcategory)')],
        _subCats = [...document.getElementsByClassName('subcategory')]

    function cat_control (d) {
        if (d === 'f') {
            _cats.forEach( e => {
                if ( ! e.parentNode.classList.contains('active') )
                    e.parentNode.style.display = 'none'
            })
        } else if (d === 'b') {
            _cats.forEach( e => {
                if ( e.parentNode.classList.contains('active') ){
                    e.parentNode.classList.remove('active')
                } else {
                    e.parentNode.style.display = 'flex'
                }
            })
        }
    }

    _cats.map(el => el.addEventListener('click', () => {

        el.parentNode.classList.add('active')
        cat_control('f')

        const _cat_back = document.querySelector('.category.active div:first-of-type')
        _cat_back.addEventListener('click', () => {
            cat_control('b')
        })

        loadData('assets/php/product_LoadByCategory.php', el.parentNode.dataset.id, (data) => {
            let html = ''

            for (let product of data)
                html += `<div class='product' id='product${product['id']}' data-id='${product['id']}' style='background: url(\"assets/img/products/${product['pictures']}\") no-repeat center center / contain'>
                            <div>
                                <h4>${product['name']}</h4>
                                <p>${product['price']}Kč</p>
                            </div>
                         </div>`

            document.getElementById('products').innerHTML = html;
            bindLoadDetail()
        })
    }))

    _subCats.map(el => el.addEventListener('click', () => {
        loadData('assets/php/products_LoadBySubCategory.php', el.dataset.id, (data) => {
            let html = ''

            for (let product of data)
                html += `<div class='product' id='product${product['id']}' data-id='${product['id']}' style='background: url(\"assets/img/products/${product['pictures']}\") no-repeat center center / contain'>
                            <div>
                                <h4>${product['name']}</h4>
                                <p>${product['price']}Kč</p>
                            </div>
                         </div>`

            document.getElementById('products').innerHTML = html;
            bindLoadDetail()
        })
    }))

    // ---------------------------------

    let _buy =  document.querySelector('[data-role="button-buy"]')

    _buy.addEventListener('click', () => {
        const xhr = new XMLHttpRequest(),
              id = document.getElementById('product-detail').dataset.id,
              cnt = document.getElementById('cnt').value

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200)
                console.log('success')
        }

        xhr.open('POST', 'assets/php/sc_AddProduct.php', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhr.send(`id=${id}&cnt=${cnt}`)

        notification('Produkt přidán do košíku.', 'SUCCESS');
    })
})
