function loadData (url, value, callback) {
    const xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200)
            callback(JSON.parse(xhr.responseText))
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhr.send(`param=${value}`)
}

function bindLoadDetail () {
    let _prods = [...document.getElementsByClassName('product')]

    _prods.map(el => el.addEventListener('click', () => {
        document.getElementById('product-detail').setAttribute('data-id', el.dataset.id)

        loadData('assets/php/loadDetail.php', el.dataset.id, (data) => {
            document.querySelector('.product-image').setAttribute('style', 'background: url("assets/img/products/' + data['pictures'][0]['url'] + '") no-repeat center center / contain')
            document.querySelector('.product-info').innerHTML = `<div>
                                                                    <h4>${data['name']}</h4>
                                                                    <p>${data['description']}</p>
                                                                </div>
                                                                <div>
                                                                    <h5>${ (data['stock'] > 0) ? 'skladem' : 'není skladem' }</h5>
                                                                    <h5>cena: ${data['price']}</h5>
                                                                    <h5>typ: ???</h5>
                                                                    <h5>tvrdost: ???</h5>
                                                                    <h5>délka štětin: ???</h5>
                                                                    <h5>barva: ???</h5>
                                                                </div>`
            document.getElementById('products').style.display = 'none'
            document.getElementById('product-detail').style.display = 'flex'
        })
    }))
}

window.addEventListener('DOMContentLoaded', () => {
    bindLoadDetail()

    // ---------------------------------

    let _cats = [...document.querySelectorAll('.category > h3')],
        _subCats = [...document.getElementsByClassName('subcategory')]

    _cats.map(el => el.addEventListener('click', () => {
        loadData('assets/php/loadProductsByCategory.php', el.parentNode.dataset.id, (data) => {
            let html = ''

            for (let product of data)
                html += `<div class='product' id='product${product['id']}' data-id='${product['id']}' style='background: url(assets/img/products/${product['pictures']}) no-repeat center center / contain'>
                            <div>
                                <h4>${product['name']}</h4>
                            </div>
                         </div>`

            document.getElementById('products').innerHTML = html;
            bindLoadDetail()
        })
    }))

    _subCats.map(el => el.addEventListener('click', () => {
        loadData('assets/php/loadProductsBySubCategory.php', el.dataset.id, (data) => {
            let html = ''

            for (let product of data)
                html += `<div class='product' id='product${product['id']}' data-id='${product['id']}' style='background: url(assets/img/products/${product['pictures']}) no-repeat center center / contain'>
                            <div>
                                <h4>${product['name']}</h4>
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
            if (xhr.readyState == 4 && xhr.status == 200)
                console.log('success')
        }

        xhr.open('POST', 'assets/php/addToShoppingCart.php', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhr.send(`id=${id}&cnt=${cnt}`)
    })

})
