package com.csis4495.aiorestaurants

import android.content.Context
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.GridView
import android.widget.Toast
import com.csis4495.aiorestaurants.adapters.AdapterDrinks
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.ItemDrinks
import com.csis4495.aiorestaurants.interfaces.OnDataPass


class FragmentMenuDrinks : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemDrinks> ? = null
    private var adapterDrinks: AdapterDrinks? = null
    private var adapterReceipt: AdapterReceipt? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {

        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        return inflater.inflate(R.layout.fragment_menu_drinks, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        var gridView:GridView ? = view.findViewById(R.id.gvDrinks)
        arrayList = ArrayList()
        arrayList = setDataList()
        adapterDrinks = context?.let { AdapterDrinks(it, arrayList!!) }
        gridView?.adapter = adapterDrinks
        gridView?.onItemClickListener = this
    }

    private fun setDataList() : ArrayList<ItemDrinks> {

        var arrayList: ArrayList<ItemDrinks> = ArrayList()

        arrayList.add(ItemDrinks("Coca-cola", "$1.99"))
        arrayList.add(ItemDrinks("Sprite", "$1.99"))
        arrayList.add(ItemDrinks("Orange Fanta", "$1.99"))
        arrayList.add(ItemDrinks("Iced Tea", "$2.49"))
        arrayList.add(ItemDrinks("Water", "$1.49"))
        arrayList.add(ItemDrinks("Sparkling Water", "$1.99"))

        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemDrinks: ItemDrinks = arrayList!![position]
        //Toast.makeText(context, itemDrinks.name, Toast.LENGTH_LONG).show()

        var name : String = itemDrinks.name.toString()
        var price : String = itemDrinks.price.toString()

        //passing data from fragment to cashier activity
        dataPasser.onDataPass(name, price)
        adapterReceipt?.notifyDataSetChanged()
    }

    //declaring data passer variable, that will pass data to cashier activity
    lateinit var dataPasser: OnDataPass

    //onAttach function
    override fun onAttach(context: Context) {
        super.onAttach(context)
        dataPasser = context as OnDataPass
    }
}