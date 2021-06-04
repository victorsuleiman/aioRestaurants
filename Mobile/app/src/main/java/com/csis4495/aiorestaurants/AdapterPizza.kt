package com.csis4495.aiorestaurants

import android.content.Context
import android.view.View
import android.view.ViewGroup
import android.widget.BaseAdapter
import android.widget.TextView

class AdapterPizza(var context: Context, var arrayList: ArrayList<ItemPizza>): BaseAdapter() {
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

        var view:View = View.inflate(context, R.layout.model_pizza, null)

        var pizzaName: TextView = view.findViewById(R.id.tvPizzaName)
        var pizzaPrice: TextView = view.findViewById(R.id.tvPizzaPrice)

        var itemPizza: ItemPizza = arrayList.get(position)

        pizzaName.text = itemPizza.name
        pizzaPrice.text = itemPizza.price

        return view
    }


}