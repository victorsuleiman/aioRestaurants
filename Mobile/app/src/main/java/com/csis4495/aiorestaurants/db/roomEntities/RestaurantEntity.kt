package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "restaurant")
data class RestaurantEntity (
    @PrimaryKey
    var name: String,
    var cashFund: Double
)