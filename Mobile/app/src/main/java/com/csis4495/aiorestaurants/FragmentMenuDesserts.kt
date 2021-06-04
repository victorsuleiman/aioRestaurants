package com.csis4495.aiorestaurants

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.GridView
import android.widget.Toast
import com.csis4495.aiorestaurants.adapters.AdapterDesserts
import com.csis4495.aiorestaurants.classes.ItemDesserts



class FragmentMenuDesserts : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemDesserts> ? = null
    private var adapterDesserts: AdapterDesserts? = null

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

        var gridView:GridView ? = view.findViewById(R.id.gvDesserts)
        arrayList = ArrayList()
        arrayList = setDataList()
        adapterDesserts = context?.let { AdapterDesserts(it, arrayList!!) }
        gridView?.adapter = adapterDesserts
        gridView?.onItemClickListener = this
    }

    private fun setDataList() : ArrayList<ItemDesserts> {

        var arrayList: ArrayList<ItemDesserts> = ArrayList()

        arrayList.add(ItemDesserts("Cinnamon Rolls", "$4.99"))
        arrayList.add(ItemDesserts("Brownie", "$1.99"))
        arrayList.add(ItemDesserts("Cookies", "$1.49"))

        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemDesserts: ItemDesserts = arrayList!![position]
        Toast.makeText(context, itemDesserts.name, Toast.LENGTH_LONG).show()
    }
}