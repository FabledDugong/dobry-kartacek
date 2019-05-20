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
        "assets/img/ad.svg",
        "https://images.unsplash.com/photo-1541442636243-5ece4a868784?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1457030642598-b037296c9296?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1551176601-c55f81516ba9?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
        "https://images.unsplash.com/photo-1550957589-fe3f828dfea2?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
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

let _categories = [...document.querySelectorAll('.category')],
    _subcategories = [...document.querySelectorAll('.subcategory')]

function subcCheck () {
    for (let i = 0; i < _categories.length; i++) {
        let t = _categories[i]
        ! t.classList.contains('active') ? t.style.display = 'none' : t.style.display = 'flex'
    }
}

_categories.map(e => e.addEventListener('click', () => {
   e.classList.add('active')
    subcCheck()
}))


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