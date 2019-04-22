'use strict'
// idk just trying something
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

        this.img.next.src = _content[1]
        this.img.next.alt = 1

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
let imgs = [
        "assets/img/pawel-czerwinski-746628-unsplash.jpg",
        "https://images.unsplash.com/photo-1541442636243-5ece4a868784?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1457030642598-b037296c9296?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1551176601-c55f81516ba9?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1550957589-fe3f828dfea2?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
    ],
    carousel = new Carousel("#carousel", imgs)

/* --------------------- */

let _vp = document.querySelector('#header').getBoundingClientRect()
console.log(_vp)
// window.addEventListener('scroll', () => {
//     if (_vp.height )
// })

function updateCheckout () {
    let _cart = document.querySelector('[data-role="button-open-cart"]')
    console.log(_cart)
    _cart.style.borderBottom = '0.25vmin solid #218F76'
    _cart.style.setProperty('after', 'display: block')
}

let _buy = document.querySelector('[data-role="button-buy"]')
_buy.addEventListener('click', () => {
    updateCheckout()
})
console.log(_buy)

let _categories = [...document.querySelectorAll('.category')],
    _subcategories = [...document.querySelectorAll('.subcategory')],
    products = document.querySelector('#products'),
    _products = [...document.querySelectorAll('.product')],
    _detail = document.querySelector('#product-detail')

function subcCheck () {
    for (let i = 0; i < _categories.length; i++) {
        let t = _categories[i]
        ! t.classList.contains('active') ? t.style.display = 'none' : t.style.display = 'block'
    }
}

function showDetail(product) {
    let product_id = product.dataset.id
    products.style.display = 'none'
    _detail.style.display = 'flex'
    console.log(product_id)
}

_categories.map(e => e.addEventListener('click', () => {
   e.classList.add('active')
    subcCheck()
}))

_products.map(e => e.addEventListener('click', () => {showDetail(e)}))


// _categories => n.classList.contains('active')


/* ----------modal controls---------- */
let _modal = document.querySelector('#modal'),
    modal_close = document.querySelector('[data-role="button-close"]'),
    modal_state = true,
    modal_operate = s => {
        if (s) {
            _modal.style.display = 'flex'
            document.body.style.overflow = 'hidden'
        } else {
            _modal.style.display = 'none'
            document.body.style.overflow = 'auto'
        }
    },
    _login = document.querySelector('#login'),
    login_open = document.querySelector('[data-role="button-open-login"]'),
    _signup = document.querySelector('#signup'),
    signup_open = document.querySelector('[data-role="link-signup"]'),
    _cart = document.querySelector('#cart'),
    cart_open = document.querySelector('[data-role="button-open-cart"]')
    // console.log(modal_close)

modal_operate(modal_state)

login_open.addEventListener('click', () => {
    _modal.style.display = 'flex';
    modal_state = true
    modal_operate(modal_state)
    /*_login.style.display = 'flex'*/
})
signup_open.addEventListener('click', () => {_login.style.display = 'none'; _signup.style.display = 'flex'})
cart_open.addEventListener('click', () => {_modal.style.display = 'flex'; _login.style.display = 'none'; _cart.style.display = 'flex'})

modal_close.addEventListener('click', () => {modal_state = false; modal_operate(modal_state)})
window.addEventListener('click', e => {
    if (e.target.getAttribute('id') === 'modal')
        _modal.style.display = 'none'
})
window.addEventListener('keydown', k => {
    if (k.code === "Escape")
        _modal.style.display = 'none'
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

const C = new Control()
const str = '            ycX73?9@B,FH    ]b\'-[tjZ | # @ c QX9.'
console.log(C.sanitizeString(str))