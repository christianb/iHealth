package com.activities;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;

/** Patient einlesen, impressum (Hilfe) */
public class MainMenu extends iHealthSuperActivity {

	private static final String TAG = "MainMenu";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.menu);
		
		RelativeLayout button1 = (RelativeLayout) findViewById(R.id.menu_button_1);
		button1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button : patient einlesen");
				
				Intent intent = new Intent (MainMenu.this, PatientView.class);
				startActivity(intent);
			}
		});
		
		RelativeLayout button2 = (RelativeLayout) findViewById(R.id.menu_button_2);
		button2.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button : impressum");
				
				Intent intent = new Intent (MainMenu.this, Impressum.class);
				startActivity(intent);
			}
		});
		
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_1_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_1_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_2_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_2_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_image_text));
	}
}
