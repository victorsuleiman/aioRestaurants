package com.csis4495.aiorestaurants.db

import com.csis4495.aiorestaurants.db.roomEntities.*
import com.squareup.moshi.JsonAdapter
import com.squareup.moshi.Moshi
import com.squareup.moshi.Types
import com.squareup.moshi.kotlin.reflect.KotlinJsonAdapterFactory

class JsonReaderAio {

    companion object {

        var moshi : Moshi = Moshi.Builder().add(KotlinJsonAdapterFactory()).build()

        fun readGoals(jsonString : String): List<GoalEntity>? {
            var jsonType = Types.newParameterizedType(List::class.java, GoalJson::class.java)

            var adapter : JsonAdapter<List<GoalJson>> = moshi.adapter(jsonType);
            var goalListJson = adapter.fromJson(jsonString)

            var goalList = arrayListOf<GoalEntity>()

            if (goalListJson != null) {
                for (goal in goalListJson) {
                    val newGoal = GoalEntity(goal.date,goal.goal,goal.sales)
                    goalList.add(newGoal)
                }
            }

            return goalList
        }

        fun readEmployees(jsonString : String): List<EmployeeEntity>? {
            var jsonType = Types.newParameterizedType(List::class.java, EmployeeJson::class.java)

            var adapter : JsonAdapter<List<EmployeeJson>> = moshi.adapter(jsonType);
            var employeeListJson = adapter.fromJson(jsonString)

            val employeeList = arrayListOf<EmployeeEntity>()

            if (employeeListJson != null) {
                for (employee in employeeListJson) {
                    val newEmployee = EmployeeEntity(employee.employeeId,employee.firstName,
                        employee.userCategory,employee.username, employee.password)
                    employeeList.add(newEmployee)
                }
            }

            return employeeList
        }

        fun readRestaurants(jsonString : String): List<RestaurantEntity>? {
            var jsonType = Types.newParameterizedType(List::class.java, RestaurantJson::class.java)

            var adapter : JsonAdapter<List<RestaurantJson>> = moshi.adapter(jsonType);
            var restaurantListJson = adapter.fromJson(jsonString)

            val restauarntList = arrayListOf<RestaurantEntity>()

            if (restaurantListJson != null) {
                for (restaurant in restaurantListJson) {
                    val newRestaurant = RestaurantEntity(restaurant.name,restaurant.cashFund)
                    restauarntList.add(newRestaurant)
                }
            }

            return restauarntList
        }

        fun readUserCategories(jsonString : String): List<UserCategoryEntity>? {
            var jsonType = Types.newParameterizedType(List::class.java, UserCategoryJson::class.java)

            var adapter : JsonAdapter<List<UserCategoryJson>> = moshi.adapter(jsonType);
            var userCategoryListJson = adapter.fromJson(jsonString)

            val userCategoryList = arrayListOf<UserCategoryEntity>()

            if (userCategoryListJson != null) {
                for (userCategory in userCategoryListJson) {
                    val newUserCategory = UserCategoryEntity(userCategory.categoryId,userCategory.category)
                    userCategoryList.add(newUserCategory)
                }
            }

            return userCategoryList
        }

        fun readDishes(jsonString : String): List<DishEntity>? {
            var jsonType = Types.newParameterizedType(List::class.java, DishJson::class.java)

            var adapter : JsonAdapter<List<DishJson>> = moshi.adapter(jsonType);
            var dishListJson = adapter.fromJson(jsonString)

            val dishList = arrayListOf<DishEntity>()

            if (dishListJson != null) {
                for (dish in dishListJson) {
                    var ingredientList = ""
                    for (ingredient in dish.ingredients) {
                        ingredientList += "${ingredient.name}|"
                    }
                    val newDish = DishEntity(dish.dishId,dish.name,dish.category,dish.price,ingredientList)
                    dishList.add(newDish)
                }
            }

            return dishList
        }
    }
}