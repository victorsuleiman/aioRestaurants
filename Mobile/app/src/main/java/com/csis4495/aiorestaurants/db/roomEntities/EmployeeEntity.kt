package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "employee")
data class EmployeeEntity (
    @PrimaryKey
    var employeeId : Int,
    var firstName: String = "",
    var userCategory: Double = 0.0,
    var username: String = "",
    var password: String = "",
)