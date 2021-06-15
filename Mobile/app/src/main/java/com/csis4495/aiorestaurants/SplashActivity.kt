package com.csis4495.aiorestaurants

import android.content.Intent
import android.os.Bundle
import android.os.Handler
import android.view.WindowManager
import android.view.animation.Animation
import android.view.animation.AnimationUtils
import android.widget.ImageView
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity

class SplashActivity : AppCompatActivity() {

    //Declaring animation variables

    //variables
    var topAnim: Animation? = null
    var bottomAnim: Animation? = null
    private lateinit var image: ImageView
    private lateinit var tv: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //hiding status bar
        window.setFlags(
            WindowManager.LayoutParams.FLAG_FULLSCREEN,
            WindowManager.LayoutParams.FLAG_FULLSCREEN
        )
        //end hiding status bar
        setContentView(R.layout.activity_splash)

        //Animations
        topAnim = AnimationUtils.loadAnimation(this, R.anim.top_animation)
        bottomAnim = AnimationUtils.loadAnimation(this, R.anim.bottom_animation)

        //hooks
        image = findViewById(R.id.ivAioSplash)
        tv = findViewById(R.id.tvRestaurantsSplash)

        //setting the animation to the image and text view
        image.setAnimation(topAnim)
        tv.setAnimation(bottomAnim)

        //redirrect to login activity after 5s
        Handler().postDelayed({
            val intent = Intent(this, LoginActivity::class.java)
            startActivity(intent)
            finish()
        }, 5000)
    }
}

