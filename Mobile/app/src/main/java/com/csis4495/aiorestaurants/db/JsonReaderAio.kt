package com.csis4495.aiorestaurants.db

import com.squareup.moshi.JsonAdapter
import com.squareup.moshi.Moshi
import com.squareup.moshi.Types
import com.squareup.moshi.kotlin.reflect.KotlinJsonAdapterFactory

class JsonReaderAio {

    companion object {

        var moshi : Moshi = Moshi.Builder().add(KotlinJsonAdapterFactory()).build()

        fun readGoals(jsonString : String): List<GoalJson>? {
            var jsonType = Types.newParameterizedType(List::class.java, GoalJson::class.java)

            var adapter : JsonAdapter<List<GoalJson>> = moshi.adapter(jsonType);
            var goalListJson = adapter.fromJson(jsonString)

            return goalListJson
        }

        fun readEmployees(jsonString : String): List<EmployeeJson>? {
            var jsonType = Types.newParameterizedType(List::class.java, EmployeeJson::class.java)

            var adapter : JsonAdapter<List<EmployeeJson>> = moshi.adapter(jsonType);
            var employeeListJson = adapter.fromJson(jsonString)

            return employeeListJson
        }

        fun readRestaurants(jsonString : String): List<RestaurantJson>? {
            var jsonType = Types.newParameterizedType(List::class.java, RestaurantJson::class.java)

            var adapter : JsonAdapter<List<RestaurantJson>> = moshi.adapter(jsonType);
            var restaurantJson = adapter.fromJson(jsonString)

            return restaurantJson
        }

        fun readUserCategories(jsonString : String): List<UserCategoryJson>? {
            var jsonType = Types.newParameterizedType(List::class.java, UserCategoryJson::class.java)

            var adapter : JsonAdapter<List<UserCategoryJson>> = moshi.adapter(jsonType);
            var userCategoryListJson = adapter.fromJson(jsonString)

            return userCategoryListJson
        }

        fun readDishes(jsonString : String): List<DishJson>? {
            var jsonType = Types.newParameterizedType(List::class.java, DishJson::class.java)

            var adapter : JsonAdapter<List<DishJson>> = moshi.adapter(jsonType);
            var dishListJson = adapter.fromJson(jsonString)

            return dishListJson
        }
    }
}