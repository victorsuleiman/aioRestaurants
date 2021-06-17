package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "userCategory")
data class UserCategoryEntity (
    @PrimaryKey
    var categoryId: Int,
    var category: String = ""
        )