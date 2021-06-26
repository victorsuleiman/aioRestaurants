package com.csis4495.aiorestaurants.classes

class ItemReceipt{

    var item:String ? = null
    var price:String ? = null

    constructor(item: String?, price: String?) {
        this.item = item
        this.price = price
    }
}

