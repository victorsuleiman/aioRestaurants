package com.csis4495.aiorestaurants.db

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.csis4495.aiorestaurants.db.roomEntities.*
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class AioViewModel (app: Application) : AndroidViewModel(app){
    private val database = AioDatabase.getDatabase(app)
    var employee = MutableLiveData<EmployeeEntity>()
    var dishList = MutableLiveData<List<DishEntity>>()
    var currentGoal = MutableLiveData<GoalEntity>()

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

    fun getEmployeeByUsername(username : String) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                val userFetched = database?.dao()?.getEmployeeByUsername(username)
                if (userFetched != null) {
                    employee.postValue(userFetched!!)
                } else {
                    employee.postValue(EmployeeEntity(0,"","",0.0,"",""))
                }
            }
        }
    }

    fun getDishByCategory (category : String) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                val dishListFromDB = database?.dao()?.getDishByCategory(category)
                dishList.postValue((dishListFromDB))
            }
        }
    }

    fun insertGoal (newGoal : GoalEntity) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.insertGoal(newGoal)
                currentGoal.postValue(newGoal)
            }
        }
    }

    fun getGoalByDate (date : String) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                val goalFetched = database?.dao()?.getGoalByDate(date)
                if (goalFetched != null) {
                    currentGoal.postValue(goalFetched!!)
                } else {
                    currentGoal.postValue(GoalEntity("",0.0,0.0))
                }
            }
        }
    }

    fun updateGoal (goal : GoalEntity) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.updateGoal(goal)
                currentGoal.postValue(goal)
            }
        }
    }

    fun updateSales (date : String, amount : Double) {
        viewModelScope.launch {
            withContext(Dispatchers.IO) {
                database?.dao()?.updateSales(amount,date)
            }
        }
    }


}