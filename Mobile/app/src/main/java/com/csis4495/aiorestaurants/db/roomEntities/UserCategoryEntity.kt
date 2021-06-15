package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "userCategory")
data class UserCategoryEntity (
    @PrimaryKey
    var categoryId: Double,
    var category: String = ""
        )