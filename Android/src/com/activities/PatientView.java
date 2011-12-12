package com.activities;

import ihealth.arduino.Communication;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.Toast;

/** Patienten daten anzeigen, messungen anzeigen, messung starten */
public class PatientView extends Activity {

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
				// testen ob BT Verbindung schon aufgebaut ist
				if (Communication.getInstance(PatientView.this).isConnected()) {
					// gehe zur nächsten activity
					Log.d(TAG, "verbuindung via bluetooth ist aktiv!");
					
				} else {
					//Toast t = Toast.makeText(getApplicationContext(), "Bitt mit Temperatursensor verbinden!", Toast.LENGTH_SHORT);
					//t.show();
					
					Intent intent = new Intent(PatientView.this, NewMeasurement.class);
					startActivity(intent);
				}
				
			}
		});
	}
}
