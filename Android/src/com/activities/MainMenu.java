package com.activities;

import org.json.JSONException;
import org.json.JSONObject;

import ihealth.utils.HexConversion;
import ihealth.webservice.RestJsonClient;
import android.app.ProgressDialog;
import android.content.Intent;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.nfc.NFC;

/** Patient einlesen, impressum (Hilfe) */
public class MainMenu extends iHealthSuperActivity {

	private static final String TAG = "MainMenu";
	private ProgressDialog dialog;
	private Tag mTagFromIntent;
	
	private String mTagID = null;
	
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
				
				if (mTagID == null) {
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
		setFontSegoeWPLight((TextView) findViewById(R.id.menu_image_text));
	}
	
	public void onNewIntent(Intent intent) {
    	
    	mTagFromIntent = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
    	//Log.d(TAG, "Tag ID = "+mTagFromIntent.);
    	byte[] tagId = intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);
    	mTagID = HexConversion.bytesToHex(tagId);
    	Log.d(TAG, "tag id = "+mTagID);
        Log.d(TAG, "call onNewIntent()");
        
        JSONObject jObject = RestJsonClient.getPatientData(mTagID);
        //Log.d(TAG, "Empfangen: " + jObject.toString());
        
        String sStatuscode = "";
		String statusmessage = "";
		
		try {
			sStatuscode = jObject.get("statuscode").toString();
			statusmessage = jObject.get("statusmessage").toString();
			Log.d(TAG, "statuscode = "+ sStatuscode);
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		int iStatuscode = new Integer(sStatuscode).intValue();
		
		if (iStatuscode == 200) {
			try {
				int userId = new Integer(jObject.getJSONObject("response").getString("userId")).intValue();
				String firstname = jObject.getJSONObject("response").getString("firstname");
				String lastname = jObject.getJSONObject("response").getString("lastname");
				
				Log.d(TAG, "User ID: "+userId);
				Log.d(TAG, "Firstname: "+firstname);
				Log.d(TAG, "Lastname: "+lastname);
				
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			Toast.makeText(this, "Patient eingelesen!", Toast.LENGTH_SHORT).show();
			
		}
		
		if (iStatuscode == 404 ) {
			Toast.makeText(this, statusmessage, Toast.LENGTH_SHORT).show();
		}
    }
	
	public void onPause() {
        super.onPause();
        mAdapter.disableForegroundDispatch(this);
    }
	
	@Override
	protected void onResume() {
		super.onResume();
		
		mAdapter.enableForegroundDispatch(MainMenu.this, pendingIntent, intentFiltersArray, techListsArray);
	}
	
	@Override
	protected void onStop() {
		// TODO Auto-generated method stub
		super.onStop();
		mTagID = null;
	}
}
