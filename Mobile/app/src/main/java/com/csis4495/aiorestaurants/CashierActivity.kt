package com.csis4495.aiorestaurants

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.WindowManager
import android.widget.Button
import android.widget.ImageView
import androidx.recyclerview.widget.LinearLayoutManager
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.ItemReceipt
import com.csis4495.aiorestaurants.interfaces.OnDataPass
import kotlinx.android.synthetic.main.activity_cashier.*

class CashierActivity : AppCompatActivity(), OnDataPass {

    //declaring buttons
    private lateinit var btnPizza: Button
    private lateinit var btnSides: Button
    private lateinit var btnDrinks: Button
    private lateinit var btnDesserts: Button
    private var adapterReceipt: AdapterReceipt? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_cashier)

        //setting button's views
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

        //changing fragment to pizza menu
        val fragmentMenuPizza = FragmentMenuPizza()
        btnPizza.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuPizza).commit()
        }

        //changing fragment to sides menu
        val fragmentMenuSides = FragmentMenuSides()
        btnSides.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuSides).commit()
        }

        //changing fragment to drinks menu
        val fragmentMenuDrinks = FragmentMenuDrinks()
        btnDrinks.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDrinks).commit()
        }

        //changing fragment to desserts menu
        val fragmentMenuDesserts = FragmentMenuDesserts()
        btnDesserts.setOnClickListener {
            supportFragmentManager.beginTransaction().replace(R.id.fragmentContainerView, fragmentMenuDesserts).commit()
        }
    }

    var count:Int = -1

    var itemReceiptList: ArrayList<ItemReceipt> = ArrayList()

    //getting data from fragment and passing into recycler view
    override fun onDataPass(item: String, price: String) {
        count++

        itemReceiptList.add(ItemReceipt(item, price))

        recyclerViewReceipt.adapter = AdapterReceipt(itemReceiptList)
        recyclerViewReceipt.layoutManager = LinearLayoutManager(this)
        recyclerViewReceipt.setHasFixedSize(true)

    }
}