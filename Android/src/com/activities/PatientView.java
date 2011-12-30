package com.activities;

import ihealth.arduino.Communication;
import ihealth.utils.Patient;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

/** Patienten daten anzeigen, messungen anzeigen, messung starten */
public class PatientView extends iHealthSuperActivity {

	private static final String TAG = "PatientView";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_overview);
		
		RelativeLayout button3 = (RelativeLayout) findViewById(R.id.patient_overview_button_3);
		button3.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click on Button 3");

				Intent intent = new Intent(PatientView.this, NewMeasurement.class);
				startActivity(intent);
			}
		});
		
		RelativeLayout button1 = (RelativeLayout) findViewById(R.id.patient_overview_button_1);
		button1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click button : patientendaten anzeigen");
				
				Intent intent = new Intent(PatientView.this, PatientDetailView.class);
				startActivity(intent);
			}
		});
		
		// TODO make members of views
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_1_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_1_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_2_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_2_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_3_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_button_3_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_overview_image_text));
		

		// Restore preferences
		//SharedPreferences sp = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
		setContent(Patient.getInstance());		
	}

	@Override
	public void readNewPatient(Patient p) {
		setContent(p);
		
	}
	
	private void setContent(Patient p) {
		TextView image_text = (TextView) findViewById(R.id.patient_overview_image_text);
		image_text.setText(p.getFirstname()+" "+p.getLastname());
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		//SharedPreferences sp = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
		setContent(Patient.getInstance());
	}
}
