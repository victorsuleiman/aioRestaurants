package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.WindowManager
import android.widget.Button
import android.widget.Toast
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.csis4495.aiorestaurants.db.AioViewModel
import com.csis4495.aiorestaurants.db.JsonReaderAio
import io.socket.client.IO
import io.socket.client.Socket
import io.socket.emitter.Emitter
import kotlinx.android.synthetic.main.activity_login.*
import java.io.InputStream
import java.net.URISyntaxException

class LoginActivity : AppCompatActivity() {

    var mSocket: Socket? = null
    private lateinit var viewModel: AioViewModel
    var username = ""
    var password = ""

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_login)

        viewModel = ViewModelProvider(this).get(AioViewModel::class.java)

        connectToBackend()

        mSocket?.on(Socket.EVENT_CONNECT, Emitter.Listener {
            Log.d("Connection to backend","sending")
        });

        mSocket?.on("onGetDishes",onGetDishes)

        mSocket?.on("onGetEmployees",onGetEmployees)

        mSocket?.on("onGetRestaurants",onGetRestaurants)

        mSocket?.on("onGetUserCategories",onGetUserCategories)

        mSocket?.on("onGetGoals",onGetGoals)

        mSocket?.emit("updatePosDatabase")

        //button to navigate from login to main activity
        val btnLogin: Button = findViewById(R.id.btnLogin)
        btnLogin.setOnClickListener {
            username = editTextUserName.text.toString()
            password = editTextPassword.text.toString()

            if (username == "" || password == "") Toast.makeText(applicationContext,"Please enter something",
                Toast.LENGTH_SHORT).show()
            else viewModel.getEmployeeByUsername(username)
        }

        viewModel.employee.observe(this, Observer {
            if (it.username == "") Toast.makeText(applicationContext,"Username not found",Toast.LENGTH_SHORT).show()
            else if (it.password == password) {
                val intent = Intent(this, MainActivity::class.java)
                startActivity(intent)
            } else {
                Toast.makeText(applicationContext,"Invalid username or password.",Toast.LENGTH_SHORT).show()
            }
        })

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

        if (dishList != null) {
            viewModel.insertAllDishes(dishList)
        }

        Log.d("Got data", "Added dishList successfully.")
    }

    var onGetEmployees = Emitter.Listener {
        val data = it[0] as String
        val employeeList = JsonReaderAio.readEmployees(data)

        if (employeeList != null) {
            viewModel.insertAllEmployees(employeeList)
        }

        Log.d("Got data", "Added employeeList successfully.")
    }

    var onGetRestaurants = Emitter.Listener {
        val data = it[0] as String
        val restaurantList = JsonReaderAio.readRestaurants(data)

        if (restaurantList != null) {
            viewModel.insertAllRestaurants(restaurantList)
        }

        Log.d("Got data", "Added restaurantList successfully.")
    }

    var onGetUserCategories = Emitter.Listener {
        val data = it[0] as String
        val userCategoryList = JsonReaderAio.readUserCategories(data)

        if (userCategoryList != null) {
            viewModel.insertAllUserCategories(userCategoryList)
        }

        Log.d("Got data", "Added userCategoryList successfully.")
    }

    var onGetGoals = Emitter.Listener {
        val data = it[0] as String
        val goalList = JsonReaderAio.readGoals(data)

        if (goalList != null) {
            viewModel.insertAllGoals(goalList)
        }

        Log.d("Got data", "Added goalList successfully.")
    }
}