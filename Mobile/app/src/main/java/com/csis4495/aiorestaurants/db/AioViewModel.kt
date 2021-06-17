package com.csis4495.aiorestaurants.db

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.viewModelScope
import com.csis4495.aiorestaurants.db.roomEntities.*
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class AioViewModel (app: Application) : AndroidViewModel(app){
    private val database = AioDatabase.getDatabase(app)

    fun insertAllDishes (dishList : List<DishEntity>) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertAllDishes(dishList)
            }
        }
    }

    fun insertAllEmployees (employeeList : List<EmployeeEntity>) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertAllEmployees(employeeList)
            }
        }
    }

    fun insertAllRestaurants (restaurantList : List<RestaurantEntity>) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertAllRestaurants(restaurantList)
            }
        }
    }

    fun insertAllGoals (goalList : List<GoalEntity>) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertAllGoals(goalList)
            }
        }
    }

    fun insertAllUserCategories (userCategoryList : List<UserCategoryEntity>) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertAllUserCategories(userCategoryList)
            }
        }
    }
}