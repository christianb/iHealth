package com.activities;

import java.util.List;

import android.app.Activity;
import android.graphics.Typeface;
import android.os.Bundle;
import android.widget.TextView;

public class iHealthSuperActivity extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
	}
	
	protected void setFontSegoeWPLight(TextView view) {
			Typeface tf = Typeface.createFromAsset(
					getBaseContext().getAssets(), "fonts/SegoeWP-Light.ttf");
			view.setTypeface(tf);			
	}
}
