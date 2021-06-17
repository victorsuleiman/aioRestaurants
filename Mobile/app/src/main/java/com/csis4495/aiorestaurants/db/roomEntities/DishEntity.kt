package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey
import com.csis4495.aiorestaurants.db.IngredientJson

@Entity(tableName = "dish")
data class DishEntity (
    @PrimaryKey
    var dishId: Int,
    var name: String = "",
    var category: String = "",
    var price: Double = 0.0,
    var ingredients: String = ""
)