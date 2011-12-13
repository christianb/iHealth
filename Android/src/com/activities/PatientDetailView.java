package com.activities;

import android.os.Bundle;
import android.widget.TextView;

/** Patientendetails: Name, Geburtstag, etc. */
public class PatientDetailView extends iHealthSuperActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_detail);
		
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_image_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_image_text_2));
	}
}
