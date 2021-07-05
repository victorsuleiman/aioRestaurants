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
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.csis4495.aiorestaurants.adapters.AdapterDesserts
import com.csis4495.aiorestaurants.adapters.AdapterDrinks
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.ItemDesserts
import com.csis4495.aiorestaurants.classes.ItemDrinks
import com.csis4495.aiorestaurants.db.AioViewModel
import com.csis4495.aiorestaurants.db.roomEntities.DishEntity
import com.csis4495.aiorestaurants.interfaces.OnDataPass


class FragmentMenuDesserts : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemDesserts> ? = null
    private var adapterDesserts: AdapterDesserts? = null
    private var adapterReceipt: AdapterReceipt? = null
    private lateinit var viewModel: AioViewModel
    private var dishListFromDB : List<DishEntity> ? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {

        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        return inflater.inflate(R.layout.fragment_menu_desserts, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel = ViewModelProvider(this).get(AioViewModel::class.java)

        viewModel.dishList.observe(viewLifecycleOwner, Observer {
            dishListFromDB = it

            if (dishListFromDB != null) {
                var gridView:GridView ? = view.findViewById(R.id.gvDesserts)
                arrayList = ArrayList()
                arrayList = setDataList()
                adapterDesserts = context?.let { AdapterDesserts(it, arrayList!!) }
                gridView?.adapter = adapterDesserts
                gridView?.onItemClickListener = this
            }

        })

        viewModel.getDishByCategory("Dessert")

    }

    private fun setDataList() : ArrayList<ItemDesserts> {

        var arrayList: ArrayList<ItemDesserts> = ArrayList()

        for (dish in dishListFromDB!!) {
            arrayList.add(ItemDesserts(dish.name,"$${dish.price}"))
        }

//        arrayList.add(ItemDesserts("Cinnamon Rolls", "$4.99"))
//        arrayList.add(ItemDesserts("Brownie", "$1.99"))
//        arrayList.add(ItemDesserts("Cookies", "$1.49"))

        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemDesserts: ItemDesserts = arrayList!![position]
        //Toast.makeText(context, itemDesserts.name, Toast.LENGTH_LONG).show()

        var name : String = itemDesserts.name.toString()
        var price : String = itemDesserts.price.toString()

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