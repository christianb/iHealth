package com.activities;

import org.json.JSONException;
import org.json.JSONObject;

import com.activities.R;

import ihealth.nfc.NFC;
import ihealth.utils.HexConversion;
import ihealth.utils.Patient;
import ihealth.webservice.RestJsonClient;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;


/** Patient einlesen, impressum (Hilfe) */
public class MainMenu extends iHealthSuperActivity {

	private static final String TAG = "MainMenu";
	private ProgressDialog dialog;
	private Tag mTagFromIntent;
	
	//private String mTagID = null;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.menu);
		
		dialog = new ProgressDialog(this);
		
		RelativeLayout button1 = (RelativeLayout) findViewById(R.id.menu_button_1);
		button1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button : patient einlesen");
				
				// Restore preferences
				SharedPreferences settings = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
				
				if (Patient.getInstance() == null) {
					Toast.makeText(MainMenu.this, "Bitte Patient einlesen", Toast.LENGTH_SHORT).show();
				} else {
					Intent intent = new Intent (MainMenu.this, PatientView.class);
					startActivity(intent);					
				}
			}
		});
		
		RelativeLayout button2 = (RelativeLayout) findViewById(R.id.menu_button_2);
		button2.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button : impressum");
				
				Intent intent = new Intent (MainMenu.this, Impressum.class);
				startActivity(intent);
			}
		});
		
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_1_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_1_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_2_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_button_2_text_2));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_headline_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_headline_2));
	}
	
	
}
