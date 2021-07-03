package com.csis4495.aiorestaurants

import android.content.Context
import android.content.DialogInterface
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.view.WindowManager
import android.widget.AdapterView
import android.widget.Button
import android.widget.ImageView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.recyclerview.widget.LinearLayoutManager
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.ItemReceipt
import com.csis4495.aiorestaurants.interfaces.OnDataPass
import kotlinx.android.synthetic.main.activity_cashier.*
import kotlinx.android.synthetic.main.activity_main.*
import kotlin.collections.ArrayList
import android.app.Activity as Activity

class CashierActivity : AppCompatActivity(), OnDataPass, AdapterReceipt.OnItemClickListener {

    //declaring buttons
    private lateinit var btnPizza: Button
    private lateinit var btnSides: Button
    private lateinit var btnDrinks: Button
    private lateinit var btnDesserts: Button

    //declaring variables to calculate total and taxes for the receipt
    private var total : Double = 0.0
    private var taxes : Double = 0.0
    private var itemPrice : Double = 0.0
    private var itemPriceStr : String = ""

    var itemReceiptList: ArrayList<ItemReceipt> = ArrayList()

    lateinit var sp : SharedPreferences

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

        sp = getSharedPreferences("sharedPreferences", Context.MODE_PRIVATE)
        textViewCashierLoggedAs.text = "Logged in as: ${sp.getString("username","")}"

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

    //getting data from fragment and passing into recycler view
    override fun onDataPass(item: String, price: String) {
        itemReceiptList.add(ItemReceipt(item, price))

        recyclerView()
        itemPriceStr = price.removePrefix("$")
        itemPrice = itemPriceStr.toDouble()
        taxes += (itemPrice * 0.05)
        total += itemPrice + (itemPrice * 0.05)

        textViewTaxes.text = "$" + taxes.round(2).toString()
        textViewTotal.text = "$" + total.round(2).toString()
    }

    //click on recycler view item
    override fun onItemClick(position: Int) {

        var builder = AlertDialog.Builder(this, R.style.Base_Theme_AppCompat_Dialog)
        builder.setTitle(getString(R.string.confirm_delete))
        builder.setMessage(getString(R.string.delete_confirmation_message))

        builder.setPositiveButton(R.string.yes, DialogInterface.OnClickListener { dialog, which ->
            DeleteItem(position)
            dialog.cancel()
        })
        builder.setNegativeButton(R.string.no, DialogInterface.OnClickListener { dialog, which ->
            dialog.cancel()
        })
        builder.show()
    }

    //recycler view function
    private fun recyclerView(){
        recyclerViewReceipt.adapter = AdapterReceipt(itemReceiptList, this)
        recyclerViewReceipt.layoutManager = LinearLayoutManager(this)
        recyclerViewReceipt.setHasFixedSize(true)
    }

    //function to format values to 2 decimal places
    private fun Double.round(decimals: Int = 2): Double = "%.${decimals}f".format(this).toDouble()

    //fucntion to delete specific item from recycler view on receipt
    private fun DeleteItem(position: Int){
        itemPriceStr = itemReceiptList.elementAt(position).price!!.removePrefix("$")
        itemPrice = itemPriceStr.toDouble()
        total -= itemPrice * 1.05
        var deletedTax : Double = itemPrice * 0.05
        taxes -= deletedTax

        textViewTaxes.text = "$" + taxes.round(2).toString()
        textViewTotal.text = "$" + total.round(2).toString()

        if(textViewTaxes.text == "$-0.0" || textViewTotal.text == "$-0.0"){
            textViewTaxes.text = "$0.0"
            textViewTotal.text = "$0.0"
        }
        itemReceiptList.removeAt(position)
        recyclerView()
    }

    //Build a Receipt Object
    private fun buildReceipt () {

    }
}