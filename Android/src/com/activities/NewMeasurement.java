package com.activities;

import ihealth.arduino.Communication;
import ihealth.arduino.MessageReceiver;
import ihealth.webservice.RestJsonClient;
import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;

public class NewMeasurement extends Activity implements MessageReceiver {

	private static final String TAG = "NewMeasurement";
	private Communication com;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.new_measurement);
		
		Spinner spinner = (Spinner) findViewById(R.id.spinner);
	    ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(
	            this, R.array.planets_array, android.R.layout.simple_spinner_item);
	    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
	    spinner.setAdapter(adapter);
		
		com = Communication.getInstance(this);
		com.registerCallback(this);
		com.startMeasurement();
		
		RelativeLayout button2 = (RelativeLayout) findViewById(R.id.new_measurement_button_2);
		button2.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button: Messung erneut starten");
				com.restartMeasurement();
			}
		});
		
		RelativeLayout button1 = (RelativeLayout) findViewById(R.id.new_measurement_button_1);
		button1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button: Messung speichern");
			}
		});
	}

	@Override
	public void receiveMeasurementResult(int value) {
		TextView textView = (TextView) findViewById(R.id.new_measurement_content_temperature);
		textView.setText(value + " Grad Celsius");
		
	}
}
