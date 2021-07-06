package com.csis4495.aiorestaurants.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView

import androidx.recyclerview.widget.RecyclerView
import com.csis4495.aiorestaurants.CashierActivity
import com.csis4495.aiorestaurants.R
import com.csis4495.aiorestaurants.classes.ItemReceipt
import kotlinx.android.synthetic.main.item_receipt.view.*

class AdapterReceipt(private val itemReceiptList: List<ItemReceipt>, private val listener: OnItemClickListener)
    : RecyclerView.Adapter<AdapterReceipt.AdapterReceiptViewHolder>() {

    inner class AdapterReceiptViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView), View.OnClickListener{
        val quantity: TextView = itemView.textViewQuantity
        val item: TextView = itemView.textViewItem
        val price: TextView = itemView.textViewItemPrice
        val delete: ImageView = itemView.imageViewDelete

        //setting onclicklistener (called view.OnClickListener on the class...)
        init {
            //item view deletes when clicking anywhere in the row, while
            // delete.set... deletes only when clicking on the delete button
            //itemView.setOnClickListener(this)
            delete.setOnClickListener(this)
        }
        override fun onClick(v: View?) {
            val position : Int = adapterPosition
            if (position != RecyclerView.NO_POSITION){
                listener.onItemClick(position)
            }
        }

    }

    interface OnItemClickListener{
        fun onItemClick(position: Int)
    }//end setting onclicklistener

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): AdapterReceiptViewHolder {
        val itemView = LayoutInflater.from(parent.context).inflate(R.layout.item_receipt,
            parent, false)

        return AdapterReceiptViewHolder(itemView)
    }

    override fun onBindViewHolder(holder: AdapterReceiptViewHolder, position: Int) {
        val currentItem = itemReceiptList[position]

        holder.quantity.text = currentItem.quantity.toString()
        holder.item.text = currentItem.item
        holder.price.text = currentItem.price
    }

    override fun getItemCount() = itemReceiptList.size
}