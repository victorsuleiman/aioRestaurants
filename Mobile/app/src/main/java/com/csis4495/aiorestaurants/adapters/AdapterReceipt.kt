package com.csis4495.aiorestaurants.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView

import androidx.recyclerview.widget.RecyclerView
import com.csis4495.aiorestaurants.R
import com.csis4495.aiorestaurants.classes.ItemReceipt
import kotlinx.android.synthetic.main.item_receipt.view.*

class AdapterReceipt(private val itemReceiptList: List<ItemReceipt>) : RecyclerView.Adapter<AdapterReceipt.AdapterReceiptViewHolder>() {

    class AdapterReceiptViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView){
        val item: TextView = itemView.textViewItem
        val price: TextView = itemView.textViewItemPrice
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): AdapterReceiptViewHolder {
        val itemView = LayoutInflater.from(parent.context).inflate(R.layout.item_receipt,
            parent, false)

        return AdapterReceiptViewHolder(itemView)
    }

    override fun onBindViewHolder(holder: AdapterReceiptViewHolder, position: Int) {
        val currentItem = itemReceiptList[position]

        holder.item.text = currentItem.item
        holder.price.text = currentItem.price
    }

    override fun getItemCount() = itemReceiptList.size
}