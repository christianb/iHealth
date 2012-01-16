package com.activities;

import ihealth.utils.Patient;
import android.os.Bundle;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;
import android.widget.TextView;

public class PatientMeasurement extends iHealthSuperActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_measurement);
		
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_measurement_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_measurement_image_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_measurement_image_text_2));
		
		
		WebView myWebView = (WebView) findViewById(R.id.myWebView);
		 // Simplest usage: note that an exception will NOT be thrown
		 // if there is an error loading this page (see below).
		myWebView.getSettings().setJavaScriptEnabled(true);
		myWebView.setWebViewClient(new WebViewClient());
		 myWebView.loadUrl("http://chart.apis.google.com/chart?cht=bvg&chs=250x150&chd=s:Monkeys&chxt=x,y&chxs=0,ff0000,12,0,lt|1,0000ff,10,1,lt");
		 
		 setContent(Patient.getInstance());
	}
	
private void setContent(Patient p) {
	
		TextView image_text = (TextView) findViewById(R.id.patient_measurement_image_text_2);
		image_text.setText(p.getFirstname()+" "+p.getLastname());
	
		TextView sex = (TextView) findViewById(R.id.patient_measurement_image_text_1);
		if (p.getSex().equalsIgnoreCase("male")) {
			sex.setText("Herr");
		} else {
			sex.setText("Frau");
		}
		
		ImageView image = (ImageView) findViewById(R.id.patient_measurement_image); 
		int i = new Integer(p.getID()).intValue();
		switch (i) {
			
			case 2: image.setImageResource(R.drawable.patient_2_small);
				break;
			case 3: image.setImageResource(R.drawable.patient_3_small);
				break;
			case 4: image.setImageResource(R.drawable.patient_4_small);
				break;
			default: image.setImageResource(R.drawable.patient_1_small);
		}
		
	}
}
