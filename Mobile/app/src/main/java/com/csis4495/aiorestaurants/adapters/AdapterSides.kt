package com.csis4495.aiorestaurants.adapters

import android.content.Context
import android.view.View
import android.view.ViewGroup
import android.widget.BaseAdapter
import android.widget.TextView
import com.csis4495.aiorestaurants.classes.ItemPizza
import com.csis4495.aiorestaurants.R
import com.csis4495.aiorestaurants.classes.ItemSides

class AdapterSides(var context: Context, var arrayList: ArrayList<ItemSides>): BaseAdapter() {
    override fun getCount(): Int {
        return arrayList.size
    }

    override fun getItem(position: Int): Any {
        return arrayList.get(position)
    }

    override fun getItemId(position: Int): Long {
        return position.toLong()
    }

    override fun getView(position: Int, convertView: View?, parent: ViewGroup?): View {

        var view:View = View.inflate(context, R.layout.model_sides, null)

        var sidesName: TextView = view.findViewById(R.id.tvSidesName)
        var sidesPrice: TextView = view.findViewById(R.id.tvSidesPrice)

        var itemSides: ItemSides = arrayList.get(position)

        sidesName.text = itemSides.name
        sidesPrice.text = itemSides.price

        return view
    }


}