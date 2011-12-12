package com.activities;

import ihealth.arduino.Communication;
import ihealth.arduino.MessageReceiver;
import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class NewMeasurement extends Activity implements MessageReceiver {

	private Communication com;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.new_measurement);
		
		com = Communication.getInstance(this);
		com.registerCallback(this);
		com.startMeasurement();
		
		RelativeLayout button2 = (RelativeLayout) findViewById(R.id.new_measurement_button_2);
		button2.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				com.restartMeasurement();
			}
		});
	}

	@Override
	public void receiveMeasurementResult(int value) {
		TextView textView = (TextView) findViewById(R.id.new_measurement_content_temperature);
		textView.setText(value + " Grad Celsius");
		
	}
}
