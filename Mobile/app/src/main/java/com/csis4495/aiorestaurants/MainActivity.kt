package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.WindowManager
import android.widget.Button
import android.widget.ImageView

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_main)

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
}