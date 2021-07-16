package com.csis4495.aiorestaurants

import android.content.Context
import android.content.DialogInterface
import android.content.Intent
import android.content.SharedPreferences
import android.icu.number.NumberFormatter
import android.opengl.Visibility
import android.os.Build
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle

import android.util.Log
import android.view.View.GONE
import android.view.View.INVISIBLE
import io.socket.client.IO
import io.socket.client.Socket
import io.socket.emitter.Emitter
import java.io.InputStream
import java.net.URISyntaxException

import android.view.WindowManager
import android.widget.*

import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.csis4495.aiorestaurants.db.AioViewModel
import com.csis4495.aiorestaurants.db.roomEntities.GoalEntity
import kotlinx.android.synthetic.main.activity_main.*
import org.json.JSONObject
import java.text.DecimalFormat
import java.time.LocalDateTime
import java.time.format.DateTimeFormatter
import kotlin.math.roundToLong


class MainActivity : AppCompatActivity() {

    var mSocket: Socket? = null
    private lateinit var viewModel: AioViewModel
    var userCat : Int = 0
    lateinit var currentGoal : GoalEntity

    @RequiresApi(Build.VERSION_CODES.O)
    val dateDate = LocalDateTime.now()

    @RequiresApi(Build.VERSION_CODES.O)
    val date = dateDate.format(DateTimeFormatter.ofPattern("yyyy-MM-dd"))

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_main)

        viewModel = ViewModelProvider(this).get(AioViewModel::class.java)

        connectToBackend()

        mSocket?.on(Socket.EVENT_CONNECT, Emitter.Listener {
            Log.d("Connection to backend","sending")
        });

        mSocket?.on("notification",onNotification)

        //image that logs the user out - goes to logout activity
        val imgLogout: ImageView = findViewById(R.id.imageViewLogout)
        imgLogout.setOnClickListener {
            val intent = Intent(this, LoginActivity::class.java)
            startActivity(intent)
        }

        //image view that goes to cashier activity
        val imageViewPointOfSale: ImageView = findViewById(R.id.imageViewPointOfSale)
        imageViewPointOfSale.setOnClickListener {
            val intent = Intent(this, CashierActivity::class.java)
            startActivity(intent)
        }

        //Shared preferences
        val sp : SharedPreferences = getSharedPreferences("sharedPreferences",Context.MODE_PRIVATE)
        textViewMainLoggedAs.text = "Logged in as: ${sp.getString("username","")}"

        editTextEmployeeId.text = sp.getInt("employeeId",0).toString()
        editTextFirstName.text = sp.getString("firstName","")
        editTextLastName.text = sp.getString("lastName","")

        userCat = sp.getInt("userCategory",0)
        val userCatString = if (userCat == 1) "Admin"
            else if (userCat == 2) "Manager"
            else "Cashier"
        editTextUserCategory.text = userCatString

        //If user is not and admin nor a manager, they are not allowed to set a sales goal.
        if (userCat != 1 && userCat != 2) {
            editTextSalesGoal.visibility = GONE
            buttonSalesGoal.visibility = GONE
        }

        viewModel.currentGoal.observe(this, Observer {
            if (it.date == "")
                textViewSalesGoal.text = "No goal specified."
            else {
                val formatter = DecimalFormat("#.##")
                textViewSalesGoal.text = "$${formatter.format(it.goal)}"
                textViewAmountSold.text = "$${formatter.format(it.sales)}"
            }
            currentGoal = it
        })

        viewModel.getGoalByDate(date)

        buttonSalesGoal.setOnClickListener {
            val goal = editTextSalesGoal.text.toString().toDouble()
            val newGoal = GoalEntity(date,goal,currentGoal.sales )

            val jsonString = "{'date' : '${newGoal.date}', 'goal' : ${newGoal.goal}, " +
                    "'sales' : ${newGoal.sales}}"

            onNewGoal(jsonString,newGoal)

            viewModel.getGoalByDate(date)

        }

    }
    
    @RequiresApi(Build.VERSION_CODES.O)
    private fun onNewGoal (jsonString : String, goal : GoalEntity) {
        var builder = AlertDialog.Builder(this, R.style.Base_Theme_AppCompat_Dialog)
        builder.setTitle(getString(R.string.confirmGoal))

        if (currentGoal.date == "") {
            builder.setMessage("Set ${goal.goal} as the goal for today?")

            builder.setPositiveButton(R.string.yes, DialogInterface.OnClickListener { dialog, which ->
                mSocket?.emit("submitGoal", JSONObject(jsonString))
                viewModel.insertGoal(goal)
                dialog.cancel()
            })
        } else {
            builder.setMessage("Goal already exists. Set ${goal.goal} as a new goal?")

            builder.setPositiveButton(R.string.yes, DialogInterface.OnClickListener { dialog, which ->
                mSocket?.emit("updateGoal",JSONObject(jsonString))
                viewModel.updateGoal(goal)
                dialog.cancel()
            })
        }

        builder.setNegativeButton(R.string.no, DialogInterface.OnClickListener { dialog, which ->
            dialog.cancel()
        })
        builder.show()
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

}