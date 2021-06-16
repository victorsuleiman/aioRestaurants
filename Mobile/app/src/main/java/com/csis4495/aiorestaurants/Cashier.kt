package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.WindowManager
import android.widget.Button
import android.widget.ImageView
import kotlinx.android.synthetic.main.activity_cashier.*

class Cashier : AppCompatActivity() {

    private lateinit var btnPizza: Button
    private lateinit var btnSides: Button
    private lateinit var btnDrinks: Button
    private lateinit var btnDesserts: Button
//    private var btnSides: Button = findViewById(R.id.btnSides)
//    private var btnDrinks: Button = findViewById(R.id.btnSoftDrinks)
//    private var btnDesserts: Button = findViewById(R.id.btnDesserts)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_cashier)

        btnPizza = findViewById(R.id.btnPizzas)
        btnSides = findViewById(R.id.btnSides)
        btnDrinks = findViewById(R.id.btnSoftDrinks)
        btnDesserts = findViewById(R.id.btnDesserts)


        //going back to home page when clicking on home image
        val imgHome: ImageView = findViewById(R.id.imageViewHome)
        imgHome.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent);
        }

        btnPizza.setBackgroundResource(R.drawable.custom_input_green) //setting pizza button layout
        btnSides.setBackgroundResource(R.drawable.custom_input_yellow)
        btnDrinks.setBackgroundResource(R.drawable.custom_input_red)
        btnDesserts.setBackgroundResource(R.drawable.custom_input_blue)

        //changing fragment to pizza menu
        val fragmentMenuPizza = FragmentMenuPizza()
        btnPizza.setOnClickListener {
           // changeBtnLayout()
            //btnPizza.setBackgroundResource(R.drawable.custom_input_green)
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuPizza).commit()
        }

        //changing fragment to sides menu
        val fragmentMenuSides = FragmentMenuSides()
        btnSides.setOnClickListener {
           // changeBtnLayout()
            //btnSides.setBackgroundResource(R.drawable.custom_input_yellow)
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuSides).commit()
        }

        //changing fragment to drinks menu
        val fragmentMenuDrinks = FragmentMenuDrinks()
        btnDrinks.setOnClickListener {
            //changeBtnLayout()
            //btnDrinks.setBackgroundResource(R.drawable.custom_input_red)
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDrinks).commit()
        }

        //changing fragment to desserts menu
        val fragmentMenuDesserts = FragmentMenuDesserts()
        btnDesserts.setOnClickListener {
            //changeBtnLayout()
            //btnDesserts.setBackgroundResource(R.drawable.custom_input_blue)
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDesserts).commit()
        }
    }

//    fun changeBtnLayout(){
//        btnPizza.setBackgroundResource(R.drawable.custom_input)
//        btnSides.setBackgroundResource(R.drawable.custom_input)
//        btnDrinks.setBackgroundResource(R.drawable.custom_input)
//        btnDesserts.setBackgroundResource(R.drawable.custom_input)
//    }
}