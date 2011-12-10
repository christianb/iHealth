package com.activities;

import android.app.Activity;
import android.os.Bundle;

/** Patienten daten anzeigen, messungen anzeigen, messung starten */
public class PatientView extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_overview);
	}
}
