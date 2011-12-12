package com.activities;

import android.app.Activity;
import android.graphics.Typeface;
import android.os.Bundle;
import android.widget.TextView;

public class Impressum extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.impressum);
		setLayoutFont();
	}
	
	public void setLayoutFont() {
	    Typeface tf = Typeface.createFromAsset(
	        getBaseContext().getAssets(), "fonts/SegoeWP-Light.ttf");
	    TextView tv = (TextView)findViewById(R.id.impressumg_headline);
	    tv.setTypeface(tf);
	    
	    tv = (TextView)findViewById(R.id.impressum_text_1);
	    tv.setTypeface(tf);
	    
	    tv = (TextView)findViewById(R.id.impressum_text_2);
	    tv.setTypeface(tf);

	}
}
