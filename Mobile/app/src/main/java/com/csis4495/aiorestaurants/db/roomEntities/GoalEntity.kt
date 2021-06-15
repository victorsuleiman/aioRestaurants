package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "goal")
data class GoalEntity (
    @PrimaryKey
    var date: String, //TODO: Try to test Date format as well.
    var goal: Double = 0.0,
    var sales: Double = 0.0

    )