package com.csis4495.aiorestaurants.db.roomEntities

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "employee")
data class EmployeeEntity (
    @PrimaryKey
    val employeeId : Int,
    val firstName: String = "",
    val userCategory: Double = 0.0,
    val username: String = "",
    val password: String = "",
)