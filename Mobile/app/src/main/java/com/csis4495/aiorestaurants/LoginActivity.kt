package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.WindowManager
import android.widget.Button

class LoginActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_login)

        //button to navigate from login to main activity
        val btnLogin: Button = findViewById(R.id.btnLogin)
        btnLogin.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent);
        }

    }
}