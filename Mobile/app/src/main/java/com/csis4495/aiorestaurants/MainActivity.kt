package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle

import android.util.Log
import android.widget.Button
import com.csis4495.aiorestaurants.db.JsonReaderAio
import io.socket.client.IO
import io.socket.client.Socket
import io.socket.emitter.Emitter
import java.io.InputStream
import java.net.URISyntaxException

import android.view.WindowManager

import android.widget.ImageView


class MainActivity : AppCompatActivity() {

    var mSocket: Socket? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_main)


        connectToBackend()

        mSocket?.on(Socket.EVENT_CONNECT, Emitter.Listener {
            Log.d("Connection to backend","sending")
        });

        mSocket?.on("notification",onNotification)

        mSocket?.on("onGetDishes",onGetDishes)

        mSocket?.on("onGetEmployees",onGetEmployees)

        mSocket?.on("onGetRestaurants",onGetRestaurants)

        mSocket?.on("onGetUserCategories",onGetUserCategories)

        mSocket?.on("onGetGoals",onGetGoals)

        mSocket?.emit("updatePosDatabase")

        //image that logs the user out - goes to logout activity
        val imgLogout: ImageView = findViewById(R.id.imageViewLogout)
        imgLogout.setOnClickListener {
            val intent = Intent(this, LoginActivity::class.java)
            startActivity(intent)
        }




        //button that goes to cashier activity

        val btnCashier: Button = findViewById(R.id.btn_cahsier)
        btnCashier.setOnClickListener {
            val intent = Intent(this, Cashier::class.java)
            startActivity(intent)
        }

    }

    fun connectToBackend() {
        var string: String? = ""
        try {
            val inputStream: InputStream = assets.open("source.txt")
            val size: Int = inputStream.available()
            val buffer = ByteArray(size)
            inputStream.read(buffer)
            string = String(buffer)
            Log.d("Read IP from txt", "Successfully read $string from txt")
        } catch (e: Exception) {
            Log.d("Read IP from txt", "Error: ${e.message.toString()}")
        }

        val ipAddress = string
        try {
            mSocket = IO.socket(ipAddress)

        } catch (e: URISyntaxException) {
            Log.d("URI error", e.message.toString())
        }

        try {
            mSocket?.connect()
            Log.d("Connection to Backend", "connected to $ipAddress, status: ${mSocket?.connected()}")
        } catch (e: Exception) {
            Log.d("Connection to Backend", "Failed to connect.")
        }
    }

    var onNotification = Emitter.Listener {
        val message = it[0] as String
        Log.d("Notification",message)
    }

    var onGetDishes = Emitter.Listener {
        val data = it[0] as String
        val dishList = JsonReaderAio.readDishes(data)
        Log.d("Got data", dishList.toString())
    }

    var onGetEmployees = Emitter.Listener {
        val data = it[0] as String
        val employeeList = JsonReaderAio.readEmployees(data)
        Log.d("Got data", employeeList.toString())
    }

    var onGetRestaurants = Emitter.Listener {
        val data = it[0] as String
        val restaurantList = JsonReaderAio.readRestaurants(data)
        Log.d("Got data", restaurantList.toString())
    }

    var onGetUserCategories = Emitter.Listener {
        val data = it[0] as String
        val userCategoryList = JsonReaderAio.readUserCategories(data)
        Log.d("Got data", userCategoryList.toString())
    }

    var onGetGoals = Emitter.Listener {
        val data = it[0] as String
        val goalList = JsonReaderAio.readGoals(data)
        Log.d("Got data", goalList.toString())
    }
}