package com.csis4495.aiorestaurants

import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle

import android.util.Log
import android.widget.Button
import io.socket.client.IO
import io.socket.client.Socket
import io.socket.emitter.Emitter
import java.io.InputStream
import java.net.URISyntaxException

import android.view.WindowManager
import android.widget.EditText

import android.widget.ImageView
import android.widget.TextView
import androidx.lifecycle.ViewModelProvider
import com.csis4495.aiorestaurants.db.AioViewModel
import kotlinx.android.synthetic.main.activity_main.*


class MainActivity : AppCompatActivity() {

    var mSocket: Socket? = null
    private lateinit var viewModel: AioViewModel

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

        //sales goal attributes
        val salesGoalEditText: EditText = findViewById(R.id.editTextSalesGoal)
        val textViewSalesGoal: TextView = findViewById(R.id.textViewSalesGoal)
        val buttonSalesGoal: Button = findViewById(R.id.buttonSalesGoal)
        val textViewUserSales: TextView = findViewById(R.id.textViewUserSales2)
        val textViewSalesDifference: TextView = findViewById(R.id.textViewSalesDifference2)

        //Shared preferences
        val sp : SharedPreferences = getSharedPreferences("sharedPreferences",Context.MODE_PRIVATE)
        textViewMainLoggedAs.text = "Logged in as: ${sp.getString("username","")}"

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