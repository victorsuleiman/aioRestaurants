package com.csis4495.aiorestaurants

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.GridView
import android.widget.Toast
import com.csis4495.aiorestaurants.adapters.AdapterSides
import com.csis4495.aiorestaurants.classes.ItemSides

class FragmentMenuSides : Fragment(), AdapterView.OnItemClickListener {

    private var gridView: GridView? = null
    private var arrayList: ArrayList<ItemSides> ? = null
    private var adapterSides: AdapterSides? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {

        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        return inflater.inflate(R.layout.fragment_menu_sides, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        var gridView:GridView ? = view.findViewById(R.id.gvSides)
        arrayList = ArrayList()
        arrayList = setDataList()
        adapterSides = context?.let { AdapterSides(it, arrayList!!) }
        gridView?.adapter = adapterSides
        gridView?.onItemClickListener = this
    }

    private fun setDataList() : ArrayList<ItemSides> {

        var arrayList: ArrayList<ItemSides> = ArrayList()

        arrayList.add(ItemSides("Cheese Sticks", "$7.99"))
        arrayList.add(ItemSides("Garlic Parmesan Breadsticks", "$5.49"))
        arrayList.add(ItemSides("Breadsticks", "$4.49"))
        arrayList.add(ItemSides("Buffalo Wings", "$11.99"))
        arrayList.add(ItemSides("BBQ Wings", "$11.99"))

        return arrayList
    }

    override fun onItemClick(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        var itemSides: ItemSides = arrayList!![position]
        Toast.makeText(context, itemSides.name, Toast.LENGTH_LONG).show()
    }
}