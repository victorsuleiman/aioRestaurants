package com.csis4495.aiorestaurants

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.GridView
import android.widget.Toast

class FragmentMenuPizza : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemPizza> ? = null
    private var adapterPizza: AdapterPizza ? = null

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

        var gridView:GridView ? = view.findViewById(R.id.gvPizza)
        arrayList = ArrayList()
        arrayList = setDataList()
        adapterPizza = context?.let { AdapterPizza(it, arrayList!!) }
        gridView?.adapter = adapterPizza
        gridView?.onItemClickListener = this
    }

    private fun setDataList() : ArrayList<ItemPizza> {

        var arrayList: ArrayList<ItemPizza> = ArrayList()

        arrayList.add(ItemPizza("Cheese - S", "$10.99"))
        arrayList.add(ItemPizza("Cheese - M", "$12.99"))
        arrayList.add(ItemPizza("Cheese - L", "$15.99"))
        arrayList.add(ItemPizza("Pepperoni - S", "$11.49"))
        arrayList.add(ItemPizza("Pepperoni - M", "$13.99"))
        arrayList.add(ItemPizza("Pepperoni - L", "$16.99"))
        arrayList.add(ItemPizza("Sausage - S", "$11.49"))
        arrayList.add(ItemPizza("Sausage - M", "$13.99"))
        arrayList.add(ItemPizza("Sausage - L", "$16.99"))
        arrayList.add(ItemPizza("All In - S", "$12.49"))
        arrayList.add(ItemPizza("All In - M", "$14.99"))
        arrayList.add(ItemPizza("All In - L", "$17.99"))
        arrayList.add(ItemPizza("Meat Lovers - S", "$11.49"))
        arrayList.add(ItemPizza("Meat Lovers - M", "$13.99"))
        arrayList.add(ItemPizza("Meat Lovers - L", "$16.99"))
        arrayList.add(ItemPizza("Hawaiian - S", "$11.49"))
        arrayList.add(ItemPizza("Hawaiian - M", "$13.99"))
        arrayList.add(ItemPizza("Hawaiian - L", "$16.99"))
        arrayList.add(ItemPizza("Chicken - S", "$11.49"))
        arrayList.add(ItemPizza("Chicken - M", "$13.99"))
        arrayList.add(ItemPizza("Chicken - L", "$16.99"))
        arrayList.add(ItemPizza("Chicken & Bacon - S", "$11.99"))
        arrayList.add(ItemPizza("Chicken & Bacon - M", "$14.49"))
        arrayList.add(ItemPizza("Chicken & Bacon - L", "$17.49"))
        arrayList.add(ItemPizza("Canadian - S", "$11.99"))
        arrayList.add(ItemPizza("Canadian - M", "$14.49"))
        arrayList.add(ItemPizza("Canadian - L", "$17.49"))

        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemPizza:ItemPizza = arrayList!![position]
        Toast.makeText(context, itemPizza.name, Toast.LENGTH_LONG).show()
    }
}