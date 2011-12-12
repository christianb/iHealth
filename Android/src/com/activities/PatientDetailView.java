package com.activities;

import android.app.Activity;
import android.os.Bundle;

/** Patientendetails: Name, Geburtstag, etc. */
public class PatientDetailView extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_detail);
	}
}
