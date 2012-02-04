package com.activities;

import com.activities.R;

import android.app.Activity;
import android.graphics.Typeface;
import android.os.Bundle;
import android.widget.TextView;

public class Impressum extends iHealthSuperActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.impressum);
		
		setFontSegoeWPLight((TextView) findViewById(R.id.impressumg_headline));
		setFontSegoeWP((TextView) findViewById(R.id.impressum_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.impressum_text_2));
	}
}
