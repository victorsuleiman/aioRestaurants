package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Button
import android.widget.ImageView

class Cashier : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_cashier)

        //going back to home page when clicking on home image
        val imgHome: ImageView = findViewById(R.id.imageViewHome)
        imgHome.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent);
        }

        //changing fragment to pizza menu
        val fragmentMenuPizza = FragmentMenuPizza()
        val btnPizza: Button = findViewById(R.id.btnPizzas)
        btnPizza.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuPizza).commit()
        }

        //changing fragment to sides menu
        val fragmentMenuSides = FragmentMenuSides()
        val btnSides: Button = findViewById(R.id.btnSides)
        btnSides.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuSides).commit()
        }

        //changing fragment to drinks menu
        val fragmentMenuDrinks = FragmentMenuDrinks()
        val btnDrinks: Button = findViewById(R.id.btnSoftDrinks)
        btnDrinks.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDrinks).commit()
        }

        //changing fragment to desserts menu
        val fragmentMenuDesserts = FragmentMenuDesserts()
        val btnDesserts: Button = findViewById(R.id.btnDesserts)
        btnDesserts.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDesserts).commit()
        }




    }
}