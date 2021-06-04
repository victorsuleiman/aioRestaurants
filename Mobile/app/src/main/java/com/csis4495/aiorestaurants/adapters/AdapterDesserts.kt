package com.csis4495.aiorestaurants.adapters

import android.content.Context
import android.view.View
import android.view.ViewGroup
import android.widget.BaseAdapter
import android.widget.TextView
import com.csis4495.aiorestaurants.R
import com.csis4495.aiorestaurants.classes.ItemDesserts

class AdapterDesserts(var context: Context, var arrayList: ArrayList<ItemDesserts>): BaseAdapter() {
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

        var view:View = View.inflate(context, R.layout.model_desserts, null)

        var dessertsName: TextView = view.findViewById(R.id.tvDessertsName)
        var dessertsPrice: TextView = view.findViewById(R.id.tvDessertsPrice)

        var itemDesserts: ItemDesserts = arrayList.get(position)

        dessertsName.text = itemDesserts.name
        dessertsPrice.text = itemDesserts.price

        return view
    }


}