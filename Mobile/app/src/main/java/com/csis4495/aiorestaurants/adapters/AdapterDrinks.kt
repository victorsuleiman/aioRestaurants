package com.csis4495.aiorestaurants.adapters

import android.content.Context
import android.view.View
import android.view.ViewGroup
import android.widget.BaseAdapter
import android.widget.TextView
import com.csis4495.aiorestaurants.R
import com.csis4495.aiorestaurants.classes.ItemDrinks

class AdapterDrinks(var context: Context, var arrayList: ArrayList<ItemDrinks>): BaseAdapter() {
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

        var view:View = View.inflate(context, R.layout.model_drinks, null)

        var drinkName: TextView = view.findViewById(R.id.tvDrinkName)
        var drinkPrice: TextView = view.findViewById(R.id.tvDrinkPrice)

        var itemDrinks: ItemDrinks = arrayList.get(position)

        drinkName.text = itemDrinks.name
        drinkPrice.text = itemDrinks.price

        return view
    }


}