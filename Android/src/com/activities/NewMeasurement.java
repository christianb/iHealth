package com.activities;

import ihealth.arduino.Communication;
import ihealth.arduino.MessageReceiver;
import ihealth.utils.HexConversion;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.IntentFilter.MalformedMimeTypeException;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.nfc.tech.MifareClassic;
import android.nfc.tech.NdefFormatable;
import android.nfc.tech.NfcA;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.nfc.NFC;

public class NewMeasurement extends iHealthSuperActivity implements MessageReceiver {

	private static final String TAG = "NewMeasurement";
	private Communication com;
	private Tag mTagFromIntent;

	
	private ProgressDialog dialog;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.new_measurement);
		
		dialog = new ProgressDialog(this);
		
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
				if (com.isConnected()) {
					com.restartMeasurement();
					dialog = ProgressDialog.show(NewMeasurement.this, "", 
	                        "Temperaturmessung läuft.\nBitte warten.", true, true);
				} else {
					Toast.makeText(NewMeasurement.this, "Keine Verbindung zum Sensor!", Toast.LENGTH_SHORT).show();
				}
			}
		});
		
		RelativeLayout button1 = (RelativeLayout) findViewById(R.id.new_measurement_button_1);
		button1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click Button: Messung speichern");
			}
		});
		
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
	
        setFontSegoeWPLight((TextView) findViewById(R.id.new_measurement_headline));
        setFontSegoeWPSemibold((TextView) findViewById(R.id.new_measurement_image_text_1));
        setFontSegoeWPSemibold((TextView) findViewById(R.id.new_measurement_image_text_2));
	}

	@Override
	public void receiveMeasurementResult(float value) {
		Log.d(TAG, "receive notification");
		TextView textView = (TextView) findViewById(R.id.new_measurement_content_temperature);
		textView.setText(value + " Grad Celsius");
		
		if (dialog.isShowing()) {
			dialog.dismiss();
		}
		
	}
	
	
	
	public void onNewIntent(Intent intent) {
    	
    	mTagFromIntent = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
    	//Log.d(TAG, "Tag ID = "+mTagFromIntent.);
    	byte[] tagId = intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);
    	Log.d(TAG, "tag id = "+HexConversion.bytesToHex(tagId));
        Log.d(TAG, "call onNewIntent()");
        
        // write tag
        NFC.writeTag(mTagFromIntent, "00:06:66:05:07:4D");
        
        byte[] payload = NFC.readTag(mTagFromIntent);
    	StringBuffer buf = new StringBuffer();
    	for (int i = 0; i < 6; i++) {
    		buf.append(HexConversion.byteToHex(payload[i]));
    		buf.append(":");
    	}
    	
    	buf.deleteCharAt(buf.length()-1);
    	String device_id = buf.toString();
    	device_id = device_id.toUpperCase();
    	Log.d(TAG, "device id: "+device_id);
        //do something with tagFromIntent
    	
    	com.setDeviceAddress(device_id);
    	com.connectToArduino();
    }
	
	public void onPause() {
        super.onPause();
        mAdapter.disableForegroundDispatch(this);
    }

    public void onResume() {
        super.onResume();
        mAdapter.enableForegroundDispatch(this, pendingIntent, intentFiltersArray, techListsArray);
    }
    
    @Override
    protected void onStop() {
    	// TODO Auto-generated method stub
    	super.onStop();
    	com.unregisterCallback(this);
    	com.disconnectFromArduino();
    }
}
