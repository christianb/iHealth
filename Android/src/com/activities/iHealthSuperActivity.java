package com.activities;

import ihealth.utils.HexConversion;
import ihealth.utils.Patient;
import ihealth.webservice.RestJsonClient;

import java.util.List;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.content.IntentFilter.MalformedMimeTypeException;
import android.graphics.Typeface;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.nfc.tech.MifareClassic;
import android.nfc.tech.NdefFormatable;
import android.nfc.tech.NfcA;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

public class iHealthSuperActivity extends Activity implements NFC_Message  {

	protected NfcAdapter mAdapter;
	protected PendingIntent pendingIntent;
	protected IntentFilter[] intentFiltersArray;
	protected String[][] techListsArray;
	
	public static final String PREFS_NAME = "iHealthPrefFile";
	
	private ProgressDialog dialog;
	private Tag mTagFromIntent;
	
	private String mTagID = null;
	
	private static final String TAG = "iHealthSuperActivity";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
		Patient.getInstance().create(getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE));
		
		// NFC access
        mAdapter = NfcAdapter.getDefaultAdapter(this);
        
        pendingIntent = PendingIntent.getActivity(
        	    this, 0, new Intent(this, getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
        
        IntentFilter ndef = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
        try {
            ndef.addDataType("*/*");    /* Handles all MIME based dispatches.
                                           You should specify only the ones that you need. */
        }
        catch (MalformedMimeTypeException e) {
            throw new RuntimeException("fail", e);
        }
        
        intentFiltersArray = new IntentFilter[] {ndef, };
       
        techListsArray = new String[][] { new String[] { NfcA.class.getName(), NdefFormatable.class.getName(), MifareClassic.class.getName() } };
    	
	}
	
	protected void setFontSegoeWPLight(TextView view) {
			Typeface tf = Typeface.createFromAsset(
					getBaseContext().getAssets(), "fonts/SegoeWP-Light.ttf");
			view.setTypeface(tf);			
	}
	
	protected void setFontSegoeWPSemibold(TextView view) {
		Typeface tf = Typeface.createFromAsset(
				getBaseContext().getAssets(), "fonts/SegoeWP-Semibold.ttf");
		view.setTypeface(tf);
	}
	
	protected void setFontSegoeWP(TextView view) {
		Typeface tf = Typeface.createFromAsset(
				getBaseContext().getAssets(), "fonts/SegoeWP.ttf");
		view.setTypeface(tf);
	}
	
	public void onNewIntent(Intent intent) {
    	
    	mTagFromIntent = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
    	//Log.d(TAG, "Tag ID = "+mTagFromIntent.);
    	byte[] tagId = intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);
    	mTagID = HexConversion.bytesToHex(tagId);
    	Log.d(TAG, "tag id = "+mTagID);
        Log.d(TAG, "call onNewIntent()");
        
        JSONObject jObject = RestJsonClient.getPatientData(mTagID);
        Log.d(TAG, "Empfangen: " + jObject.toString());
        
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
				String userId  = jObject.getJSONObject("response").getString(Patient.ID);
				String firstname = jObject.getJSONObject("response").getString(Patient.FIRSTNAME);
				String lastname = jObject.getJSONObject("response").getString(Patient.LASTNAME);
				String bloodGroup = jObject.getJSONObject("response").getString(Patient.BLOOD_GROUP);
				String size = jObject.getJSONObject("response").getString(Patient.SIZE);
				String weight = jObject.getJSONObject("response").getString(Patient.WEIGHT);
				String street = jObject.getJSONObject("response").getJSONObject("address").getString(Patient.STREET);
				String zipcode = jObject.getJSONObject("response").getJSONObject("address").getString(Patient.ZIPCODE);
				String city = jObject.getJSONObject("response").getJSONObject("address").getString(Patient.CITY);
				String birthday = jObject.getJSONObject("response").getString(Patient.BIRTHDAY);
				
				Log.d(TAG, "User ID: "+userId);
				Log.d(TAG, "Firstname: "+firstname);
				Log.d(TAG, "Lastname: "+lastname);
				Log.d(TAG, "BloodGroup: "+bloodGroup);
				Log.d(TAG, "size: "+size);
				Log.d(TAG, "Street: "+street);
				Log.d(TAG, "zipcode: "+zipcode);
				Log.d(TAG, "city: "+city);
				Log.d(TAG, "birthday: "+birthday);
				Log.d(TAG, "weight: "+weight);
				
				SharedPreferences settings = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
				
				SharedPreferences.Editor editor = settings.edit();
				editor.putString(Patient.ID, userId);
				editor.putString(Patient.FIRSTNAME, firstname);
				editor.putString(Patient.LASTNAME, lastname);
				
				editor.putString(Patient.BLOOD_GROUP, bloodGroup);
				editor.putString(Patient.SIZE, size);
				editor.putString(Patient.STREET, street);
				editor.putString(Patient.ZIPCODE, zipcode);
				editor.putString(Patient.CITY, city);
				editor.putString(Patient.WEIGHT, weight);
				editor.putString(Patient.BIRTHDAY, birthday);
				
				// Commit the edits!
				editor.commit();
								
				readNewPatient(Patient.getInstance().create(settings));
				
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
		
		mAdapter.enableForegroundDispatch(this, pendingIntent, intentFiltersArray, techListsArray);
	}
	
	@Override
	protected void onStop() {
		// TODO Auto-generated method stub
		super.onStop();
		mTagID = null;
	}

	@Override
	public void readNewPatient(Patient p) {
		
	}
}
