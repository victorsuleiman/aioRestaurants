package com.csis4495.aiorestaurants

import android.content.Context
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.GridView
import android.widget.Toast
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.csis4495.aiorestaurants.adapters.AdapterPizza
import com.csis4495.aiorestaurants.adapters.AdapterReceipt
import com.csis4495.aiorestaurants.classes.ItemPizza
import com.csis4495.aiorestaurants.db.AioViewModel
import com.csis4495.aiorestaurants.db.roomEntities.DishEntity
import com.csis4495.aiorestaurants.interfaces.OnDataPass
import kotlinx.android.synthetic.main.item_receipt.*

class FragmentMenuPizza : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemPizza> ? = null
    private var dishListFromDB : List<DishEntity> ? = null
    private var adapterPizza: AdapterPizza? = null
    private var adapterReceipt: AdapterReceipt? = null
    private lateinit var viewModel: AioViewModel

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        arguments?.let {

        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        return inflater.inflate(R.layout.fragment_menu_pizza, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel = ViewModelProvider(this).get(AioViewModel::class.java)

        viewModel.dishList.observe(viewLifecycleOwner, Observer {
            dishListFromDB = it

            if (dishListFromDB != null) {
                var gridView:GridView ? = view.findViewById(R.id.gvPizza)
                arrayList = ArrayList()
                arrayList = setDataList()
                adapterPizza = context?.let { AdapterPizza(it, arrayList!!) }
                gridView?.adapter = adapterPizza
                gridView?.onItemClickListener = this
            }

        })

        viewModel.getDishByCategory("Pizza")

    }

    private fun setDataList() : ArrayList<ItemPizza> {

        var arrayList: ArrayList<ItemPizza> = ArrayList()

        for (dish in dishListFromDB!!) {
            arrayList.add(ItemPizza(dish.name,"$${dish.price}"))
        }
        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemPizza: ItemPizza = arrayList!![position]
        //Toast.makeText(context, itemPizza.name, Toast.LENGTH_LONG).show()

        var name : String = itemPizza.name.toString()
        var price : String = itemPizza.price.toString()

        dataPasser.onDataPass(name, price)

        adapterReceipt?.notifyDataSetChanged()

    }

    lateinit var dataPasser: OnDataPass

    override fun onAttach(context: Context) {
        super.onAttach(context)
        dataPasser = context as OnDataPass
    }
}