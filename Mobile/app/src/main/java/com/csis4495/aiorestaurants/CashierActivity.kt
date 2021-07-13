package com.csis4495.aiorestaurants

import android.content.Context
import android.content.DialogInterface
import android.content.Intent
import android.content.SharedPreferences
import android.os.Build
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.WindowManager
import android.widget.Button
import android.widget.ImageView
import android.widget.Toast
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.recyclerview.widget.LinearLayoutManager
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.Dish
import com.csis4495.aiorestaurants.classes.ItemReceipt
import com.csis4495.aiorestaurants.classes.Receipt
import com.csis4495.aiorestaurants.interfaces.OnDataPass
import io.socket.client.IO
import io.socket.client.Socket
import io.socket.emitter.Emitter
import kotlinx.android.synthetic.main.activity_cashier.*
import org.json.JSONObject
import java.io.InputStream
import java.net.URISyntaxException
import java.time.LocalDateTime
import java.time.format.DateTimeFormatter
import java.util.*
import kotlin.collections.ArrayList

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

    var mSocket: Socket? = null

    @RequiresApi(Build.VERSION_CODES.O)
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

        connectToBackend()

        mSocket?.on(Socket.EVENT_CONNECT, Emitter.Listener {
            Log.d("Connection to backend","sending")
        });

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

        btnCash.setOnClickListener {
            onPaymentClick("cash")
        }

        btnDebit.setOnClickListener {
            onPaymentClick("debit")
        }

        btnCredit.setOnClickListener {
            onPaymentClick("credit")
        }

    }

    //getting data from fragment and passing into recycler view
    override fun onDataPass(item: String, price: String) {

        var quantity: Int? = 1

        for (i in 0..(itemReceiptList.size - 1)){
            if(itemReceiptList[i] != null){
                if(itemReceiptList[i].item.equals(item)){
                    quantity = itemReceiptList[i].quantity?.plus(1)
                    DeleteItem(i)
                    break
                }
                else{
                    quantity = 1
                }
            }
        }

        itemReceiptList.add(ItemReceipt(quantity, item, price))

        val quantity2: Int = quantity!!.toInt()

        recyclerView()
        itemPriceStr = price.removePrefix("$")
        itemPrice = itemPriceStr.toDouble() * quantity2
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
        itemReceiptList.sortBy { it.item }
        recyclerViewReceipt.adapter = AdapterReceipt(itemReceiptList, this)
        recyclerViewReceipt.layoutManager = LinearLayoutManager(this)
        recyclerViewReceipt.setHasFixedSize(true)
    }

    //function to format values to 2 decimal places
    private fun Double.round(decimals: Int = 2): Double = "%.${decimals}f".format(this).toDouble()

    //fucntion to delete specific item from recycler view on receipt
    private fun DeleteItem(position: Int){

        var quantity: Int = itemReceiptList.elementAt(position).quantity!!

        itemPriceStr = itemReceiptList.elementAt(position).price!!.removePrefix("$")
        itemPrice = itemPriceStr.toDouble() * quantity
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
    @RequiresApi(Build.VERSION_CODES.O)
    private fun buildReceipt(paymentType: String): Receipt {
        val server = sp.getString("firstName", "")
        val employeeId = sp.getInt("employeeId", 0)

        //dish list
        val dishList = mutableListOf<Dish>()
        for (dish in itemReceiptList) {
            dish.item?.let { dishList.add(Dish(dish.item!!,dish.price!!.removePrefix("$").toDouble(),
                dish.quantity ?: 0)) }
        }

        val taxes = taxes
        val total = total

        val dateDate = LocalDateTime.now()
        val date = dateDate.format(DateTimeFormatter.ofPattern("yyyy-MM-dd"))

        return Receipt(server, employeeId, dishList, taxes, total, paymentType, date)

    }

    @RequiresApi(Build.VERSION_CODES.O)
    private fun onPaymentClick (paymentType : String) {
        var builder = AlertDialog.Builder(this, R.style.Base_Theme_AppCompat_Dialog)
        builder.setTitle(getString(R.string.confirmPayment))
        builder.setMessage("Start payment by $paymentType and submit receipt?")

        builder.setPositiveButton(R.string.yes, DialogInterface.OnClickListener { dialog, which ->
            if (itemReceiptList.isNotEmpty()) {
                val receipt = buildReceipt(paymentType)
                submitReceipt(receipt)
                Log.d("Receipt Test","Receipt built.")
            } else {
                Toast.makeText(applicationContext,"Cart is empty.",Toast.LENGTH_SHORT).show()
            }
            dialog.cancel()
        })
        builder.setNegativeButton(R.string.no, DialogInterface.OnClickListener { dialog, which ->
            dialog.cancel()
        })
        builder.show()
    }

    private fun submitReceipt (receipt : Receipt) {

        var dishes = ""
        for (dish in receipt.dishes) {
            dishes += if (dish != receipt.dishes.last()) {
                "{'name' : '${dish.name}','price' : ${dish.price},'qty' : ${dish.qty}}, "
            } else {
                "{'name' : '${dish.name}','price' : ${dish.price},'qty' : ${dish.qty}}"
            }
        }

        val jsonString = "{'server' : '${receipt.server}', 'employeeId' : ${receipt.employeeId}, " +
                "'dishes' : [${dishes}], 'taxes' : ${receipt.taxes.round(2)}, " +
                "'total' : ${receipt.total.round(2)}, " +
                "'paymentType' : '${receipt.paymentType}', 'date' : '${receipt.date}'}"

        mSocket?.emit("submitReceipt",JSONObject(jsonString))

        //Clear cart
        for (item in 1..itemReceiptList.size) {
            DeleteItem(0)
        }

        Toast.makeText(applicationContext,"Receipt submitted successfully.",Toast.LENGTH_LONG).show()
    }

    private fun connectToBackend() {
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
}