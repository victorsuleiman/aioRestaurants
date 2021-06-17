package com.csis4495.aiorestaurants.db

import androidx.lifecycle.LiveData
import androidx.room.Dao
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import com.csis4495.aiorestaurants.db.roomEntities.*

@Dao
interface AioDao {

    //InsertAll queries
    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAllDishes(dishList : List<DishEntity>)

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAllEmployees(employeeList : List<EmployeeEntity>)

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAllGoals(goalList : List<GoalEntity>)

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAllRestaurants(restaurantList : List<RestaurantEntity>)

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAllUserCategories(userCategoryList : List<UserCategoryEntity>)

    //Insert single value queries
    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertGoal(newGoal : GoalEntity)

    //GetAll queries
    @Query("SELECT * FROM dish")
    fun getAllDishes() : LiveData<List<DishEntity>>

    @Query("SELECT * FROM employee")
    fun getAllEmployees() : LiveData<List<EmployeeEntity>>

    @Query("SELECT * FROM goal")
    fun getAllGoals() : LiveData<List<DishEntity>>

    @Query("SELECT * FROM restaurant")
    fun getAllRestaurants() : LiveData<List<RestaurantEntity>>

    @Query("SELECT * FROM dish")
    fun getAllUserCategories() : LiveData<List<UserCategoryEntity>>

    //GetByAtt queries
    @Query("SELECT * FROM dish WHERE name = :name")
    suspend fun getDishByName(name : String) : DishEntity

    @Query("SELECT * FROM employee WHERE username = :username")
    suspend fun getEmployeeByUsername(username : String) : EmployeeEntity

    @Query("SELECT * FROM goal WHERE date = :date")
    suspend fun getGoalByDate(date : String) : GoalEntity

    @Query("SELECT * FROM userCategory WHERE categoryId = :id")
    suspend fun getUserCategoryById(id : Int) : UserCategoryEntity




}