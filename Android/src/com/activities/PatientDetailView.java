package com.activities;

import android.content.Context;
import android.content.SharedPreferences;
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
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_birthdate));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_birthday_description));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_blutgruppe));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_blutgruppe_description));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_checkin_date));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_checkin_date_description));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_name));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_name_description));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_weight));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_weight_description));
		
		// Restore preferences
		SharedPreferences settings = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
		
		TextView image_text = (TextView) findViewById(R.id.patient_details_image_text_2);
		image_text.setText(settings.getString("firstname", "??")+" "+settings.getString("lastname", " ??"));
		
		TextView name = (TextView) findViewById(R.id.patient_details_content_name);
		name.setText(settings.getString("firstname", "??")+" "+settings.getString("lastname", " ??"));
		
	}
}
