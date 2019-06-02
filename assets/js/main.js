'use strict'

'use strict'

class Carousel {
    constructor(_target, _content) {
        this.target = _target
        this.src = _content
        this.len = _content.length
        this.active = 0
        this.img = {
            prev: document.createElement('img'),
            active: document.createElement('img'),
            next: document.createElement('img')
        }
        this.animRun = false

        this.img.prev.src = _content[this.len - 1]
        this.img.prev.alt = this.len - 1

        this.img.active.src = _content[0]
        this.img.active.alt = 0

        let tmp_cnt = ( this.len < 2 ) ? 0 : 1
        this.img.next.src = _content[tmp_cnt]
        this.img.next.alt = tmp_cnt

        for(let i in this.img)
            document.querySelector(_target + ' .images').appendChild(this.img[i])

        for(let i = 0; i < this.len; i++) {
            let bar = document.createElement('div')
            bar.classList.add('bar')
            bar.onclick = () => {this.select(i)}
            document.querySelector(_target + ' .status').appendChild(bar)
        }
        document.querySelector(_target + ' .bar').classList.add('active')

        document.querySelector(_target + ' .controls .prev').onclick = () => {
            if(!this.animRun)
                this.prev()
        }
        document.querySelector(_target + ' .controls .next').onclick = () => {
            if(!this.animRun)
                this.next()
        }

        //for phones
        // let startX = 0,
        //     tarEl = document.querySelector(_target),
        //     imgEl = document.querySelector(_target + ' .images')

//     tarEl.ontouchstart = (e) => {startX = e.touches[0].clientX}

//     tarEl.ontouchmove = (e) => {
//       imgEl.style.left = -(startX - e.changedTouches[0].clientX) + 'px'
//     }

//     tarEl.ontouchend = (e) => {
//       let top = getComputedStyle(imgEl).top.match(/[-]?[0-9]{1,}/)[0]

//       if(top < 0 && (-top >= (tarEl.getBoundingClientRect().height / 2)))
//         this.next()
//       else if(top > 0 && (top >= (tarEl.getBoundingClientRect().height / 2)))
//         this.prev()
//       else
//         imgEl.style.left = 0
//     }
        //preloading imgs to prevent lag
        let _preload = document.createElement('div')
        for (let img of _content) {
            let tmpImg = document.createElement('img')
            tmpImg.src = img
            _preload.appendChild(tmpImg)
        }
        _preload.style.display = 'none'
        document.querySelector(this.target + ' .images').appendChild(_preload)
    }

    //moves the imgs by one back
    prev() {
        this.active = (this.active > 0) ? this.active - 1 : this.len - 1
        this.move('<-')
    }

    //moves the imgs by one forward
    next() {
        this.active = (this.active < this.len - 1) ? this.active + 1 : 0
        this.move('->')
    }

    //animates and moves the imgs
    move(direction) {
        let container = document.querySelector(this.target + ' .images'),
            bcr = container.getBoundingClientRect(),
            prev = (this.active > 0) ? this.active - 1 : this.len - 1,
            next = (this.active < this.len - 1) ? this.active + 1 : 0,
            self = this,
            step = Math.round(bcr.height / 15)

        //animation
        function anim(dir) {
            let top = getComputedStyle(container).top.match(/[-]?[0-9]{1,}/)[0]
            self.animRun = true

            if(dir === '->' && (-top < bcr.height)) {

                if((bcr.height + +(top)) < step)
                    step = bcr.height + +(top)

                container.style.top = (top - step) + 'px'
                window.requestAnimationFrame(() => {anim(direction)})

            } else if(dir === '<-' && (top < bcr.width)) {

                if((bcr.height - +(top)) < step)
                    step = bcr.height - +(top)

                container.style.top = (+(top) + step) + 'px'
                window.requestAnimationFrame(() => {anim(direction)})

            } else {

                //switches the src of imgs -> active one in middle, prev on the left, next on the right
                self.img.prev.src = self.src[prev]
                self.img.prev.alt = prev

                self.img.active.src = self.src[self.active]
                self.img.active.alt = self.active

                self.img.next.src = self.src[next]
                self.img.next.alt = next

                container.style.top = 0
                self.animRun = false

            }
        }
        window.requestAnimationFrame(() => {anim(direction)})

        this.mark(this.active)
    }

    //switches active img when clicking on one of the bars in the bottom
    select(index) {
        if(index > this.active) {

            this.img.next.src = this.src[index]
            this.active = index
            this.move('->')

        } else if(index < this.active) {

            this.img.prev.src = this.src[index]
            this.active = index
            this.move('<-')

        }
    }

    //marks active bar in the bottom
    mark(index) {
        let bars = document.querySelectorAll(this.target + ' .status .bar')

        for(let bar of bars) {
            if(bar.classList.contains('active'))
                bar.classList.remove('active')
        }

        bars[index].classList.add('active')
    }

}

//add how many pictures you want
const imgs = [
        "assets/img/campaign.svg",
        "assets/img/campaign_1.svg",
        "assets/img/campaign.svg"
        // "https://images.unsplash.com/photo-1541442636243-5ece4a868784?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        // "https://images.unsplash.com/photo-1457030642598-b037296c9296?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        // "https://images.unsplash.com/photo-1551176601-c55f81516ba9?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        // "https://images.unsplash.com/photo-1550957589-fe3f828dfea2?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
    ],
    carousel = new Carousel("#carousel", imgs)

/* --------------------- */

const menu = document.getElementById('navigation'),
    menuTop = menu.offsetTop,
    header = document.querySelector('#intro'),
    tmp = document.createElement('div')
window.addEventListener('scroll', () => {
    if ( menuTop <= window.pageYOffset ) {
        menu.setAttribute('style', 'width:' + menu.getBoundingClientRect().width + 'px')
        setTimeout(() => {
            menu.classList.add('pinned')
        }, 10)
        header.insertBefore(tmp,header.children[0])
    } else {
        menu.setAttribute('style', '')
        setTimeout(() => {
            menu.setAttribute('style', 'width: initial')
            menu.classList.remove('pinned')
        }, 10)
        tmp.remove()
    }
})

/* --------------------- */

function updateCheckout () {
    let _cart = document.querySelector('[data-role="button-open-cart"]')
    _cart.style.setProperty('after', 'display: inline-flex')
}

let _buy = document.querySelector('[data-role="button-buy"]')
_buy.addEventListener('click', () => {
    updateCheckout()
})

let _back = document.querySelector('[data-role="button-back"]')
_back.addEventListener('click', () => {
    document.getElementById('products').style.display = 'flex'
    document.getElementById('product-detail').style.display = 'none'
})

/* ----------modal controls---------- */
let _modal = document.querySelector('#modal'),
    modal_children = [..._modal.children],
    modal_close = [...document.querySelectorAll('[data-role="button-modal-close"]')],
    modal_operate = (s, e, a = false) => {
        if (s) {
            _modal.style.display = 'flex'
            document.body.style.overflowY = 'hidden'
            if (a) {
                modal_children.forEach((el) => {
                    console.log(el)
                    if (el.classList.contains('modal-active'))
                        console.log('true')
                    el.classList.remove('modal-active')
                })
            }
            console.log(e.getAttribute('id'))
            switch (e.getAttribute('id')) {
                case 'login':
                    _login.classList.add('modal-active')
                    break;
                case 'signup':
                    _signup.classList.add('modal-active')
            }
        } else {
            _modal.style.display = 'none'
            modal_children.forEach((e) => {
                if (e.classList.contains('modal-active'))
                    e.classList.remove('modal-active')
            })
            document.body.style.overflowY = 'auto'
        }
    },
    _login = document.querySelector('#login'),
    login_open = document.querySelector('[data-role="button-open-login"]'),
    _signup = document.querySelector('#signup'),
    signup_open = document.querySelector('[data-role="link-signup"]')

/* tabindex off if modal on */
const menu_items = [...document.getElementById('menu').children]

menu_items.forEach(e => {

})

login_open.addEventListener('click', () => {
    modal_operate(true, _login)
})
signup_open.addEventListener('click', () => {
    modal_operate(true, _signup, true)
})

modal_close.map(e => e.addEventListener('click', () => {
    modal_operate(false)
}))
window.addEventListener('click', e => {
    if (e.target.getAttribute('id') === 'modal')
        modal_operate(false)
})
window.addEventListener('keydown', k => {
    if (k.code === "Escape")
        modal_operate(false)
})

/* ----------login control---------- */
class Control {
    constructor () {
    }

    sanitizeString(str) {
        const r = /[^a-zá-ž0-9]/g

        str = str.trim()
        str = str.toLowerCase()
        str = str.replace(r, '')
        return str
    }

    parsefs(type) {

        switch (type) {
            case 'email':
                break;
            case 'pass':
                break;
            default:
                break;
        }

    }

}

// const C = new Control()
// const str = '            ycX73?9@B,FH    ]b\'-[tjZ | # @ c QX9.'
// console.log(C.sanitizeString(str))





'use strict'

function loadData (url, data, callback) {
    const xhr = new XMLHttpRequest()
    let args = ''

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log ( xhr.responseText )

            callback(JSON.parse(xhr.responseText))
        }
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

    for ( let key in data )
        args += ( key + '=' + data[key] + '&' )

    xhr.send( args.slice( 0, -1 ) )
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

        loadData('assets/php/handlers/product/select_by_id.php', {'id' : el.dataset.id}, (data) => {
            document.querySelector('.product-image').setAttribute('style', 'background: url("assets/img/products/' + data['pictures'][0] + '") no-repeat center center / contain')
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

        loadData('assets/php/handlers/product/select_by_category.php', {'id_category' : el.parentNode.dataset.id}, (data) => {
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
        loadData('assets/php/handlers/product/select_by_category.php', {'id_category' : el.dataset.id}, (data) => {
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