package com.csis4495.aiorestaurants.classes

class ItemReceipt{

    var quantity:Int ? = null
    var item:String ? = null
    var price:String ? = null

    constructor(quantity: Int?, item: String?, price: String?) {
        this.quantity = quantity
        this.item = item
        this.price = price
    }
}

