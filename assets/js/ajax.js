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
                                <td>skladem</td>
                                <td><mark style='color: ${ (data['stock'] > 0) ? '#52c234' : '#DD3B4E' }'>${ (data['stock'] > 0) ? 'ano' : 'ne' }</mark></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>cena bez dph</td>
                                <td><mark>${data['price']-((data['price']/100)*21)}</mark> Kč</td>
                            </tr>                   
                            <tr>
                                <td>cena</td>
                                <td><mark>${data['price']}</mark> Kč</td>
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
        _subCats = [...document.getElementsByClassName('subcategory')],
        _opened = false


    _cats.map(el => el.addEventListener('click', () => {

        el.parentNode.classList.toggle('active')

        let _sCats = [...document.querySelectorAll( '.category.active > .subcategory' )],
            _sCats2 = [...document.querySelectorAll('.category > div:not(.subcategory)')]

        if ( !_opened ) {
            for ( let cat of _sCats )
                if ( !el.parentNode.classList.contains( 'active' ) )
                    cat.parentNode.style.display = 'none'
                else
                    cat.parentNode.style.display = 'flex'

            for ( let cat of _sCats2 )
                if ( !cat.parentNode.classList.contains( 'active' ) )
                    cat.parentNode.style.display = 'none'
                else
                    cat.parentNode.style.display = 'flex'

            _opened = true;
        } else {
            for ( let cat of _sCats )
                cat.parentNode.style.display = 'none'

            for ( let cat of _sCats2 )
                cat.parentNode.style.display = 'flex'

            _opened = false;
        }

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

    const   _buy =  document.querySelector('[data-role="button-buy"]'),
            _sc = document.getElementById('ct')

    _buy.addEventListener('click', () => {
        const   xhr = new XMLHttpRequest(),
                id = document.getElementById('product-detail').dataset.id,
                cnt = document.getElementById('cnt').value,
                name = document.querySelectorAll('.product-info h4')

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

    // const x = new XMLHttpRequest()
    // x.onreadystatechange = function () {
    //     if (xhr.readyState === 4 && xhr.status === 200)
    //         console.log('success')
    // }
    //
    // x.open('GET', 'assets/php/sc_Empty', true)
    // x.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    // x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    // x.send()
    //
    // if (!x)
})
