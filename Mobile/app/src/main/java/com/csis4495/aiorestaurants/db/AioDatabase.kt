package com.csis4495.aiorestaurants.db

import android.content.Context
import androidx.room.Database
import androidx.room.Room
import androidx.room.RoomDatabase
import com.csis4495.aiorestaurants.db.roomEntities.*

@Database(entities = [DishEntity::class, EmployeeEntity::class, RestaurantEntity::class, UserCategoryEntity::class, GoalEntity::class],
    version = 1, exportSchema = false)
abstract class AioDatabase : RoomDatabase() {
    abstract fun dao() : AioDao

    companion object{
        @Volatile
        private var INSTANCE : AioDatabase? = null;

        fun getDatabase(context : Context) : AioDatabase?{
            if(INSTANCE == null){
                synchronized(AioDatabase::class){
                    INSTANCE = Room.databaseBuilder(
                        context.applicationContext,
                        AioDatabase::class.java,
                        "aioDatabase.db"
                    ).build();
                }
            }
            return INSTANCE;
        }
    }
}