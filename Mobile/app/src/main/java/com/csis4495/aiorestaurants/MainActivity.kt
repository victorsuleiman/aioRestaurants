package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Button

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val btnCashier: Button = findViewById(R.id.btn_cahsier)
        btnCashier.setOnClickListener {
            val intent = Intent(this, Cashier::class.java)
            startActivity(intent);
        }

    }
}