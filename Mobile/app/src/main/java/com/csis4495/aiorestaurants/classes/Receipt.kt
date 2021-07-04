package com.csis4495.aiorestaurants.classes

data class Receipt (
    val server : String? = "",
    val employeeId : Int = 0,
    val dishes : List<String>,
    val taxes : Double = 0.0,
    val total : Double = 0.0,
    val paymentType : String = "",
    val date : String = ""

        )