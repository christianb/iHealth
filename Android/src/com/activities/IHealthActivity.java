package com.activities;

import java.math.BigInteger;
import java.nio.charset.Charset;

import ihealth.arduino.Communication;
import ihealth.arduino.MessageReceiver;
import ihealth.utils.HexConversion;
import ihealth.webservice.RestJsonClient;

import org.json.JSONObject;

import com.nfc.NFC;

import android.app.Activity;
import android.app.PendingIntent;
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
import android.widget.Button;

public class IHealthActivity extends Activity implements MessageReceiver {
	
	private final static String TAG = "IHealthActivity";
	
	private Communication comm;
	
	private Button startMeasurement;

	private IntentFilter[] intentFiltersArray;

	private String[][] techListsArray;

	private NfcAdapter mAdapter;

	private PendingIntent pendingIntent;

	private Tag mTagFromIntent;

	private Communication com;
	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        
        //JSONObject jObject = RestJsonClient.loginPOST("christian", "qwertz");
        //JSONObject jObject = RestJsonClient.getPatientData(4);
        String userID = "01";
        JSONObject jObject = RestJsonClient.createMeasurement("42", "temperature", "36", "Normale Kšrpertemperatur", userID);
        Log.d(TAG, "Empfangen: " + jObject.toString());
        
		/*		Log.d(TAG, "Sha1: " + Sha1.getHash("Hallo Welt"));

        
        startMeasurement = (Button) findViewById(R.id.startMeasurement);
        
        startMeasurement.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				startMeasurement();
			}
		});
        
        comm = new Communication(this, "00:06:66:05:07:4D");
        comm.connectToArduino();
        comm.registerCallback(this);*/
        
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
        
        com = new Communication(this);
    }
    
    public String toHex(String arg) {
	    return String.format("%x", new BigInteger(arg.getBytes(Charset.forName("US-ASCII"))));
	}
    
    public void onPause() {
        super.onPause();
        mAdapter.disableForegroundDispatch(this);
    }

    public void onResume() {
        super.onResume();
        mAdapter.enableForegroundDispatch(this, pendingIntent, intentFiltersArray, techListsArray);
    }

    public void onNewIntent(Intent intent) {
    	
    	mTagFromIntent = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
        Log.d(TAG, "call onNewIntent()");
        
        // write tag
        NFC.writeTag(mTagFromIntent, "42:06:66:05:07:4D");
        
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
    	
    	
    	com.connectToArduino();
    }
    
    @Override
    protected void onStop() {
    	// TODO Auto-generated method stub
    	super.onStop();
    	com.disconnectFromArduino();
    }
    
    @Override
	protected void onDestroy() {
		//comm.disconnectFromArduino();
		//comm.unregisterCallback(this);
		
		super.onStop();
	}

    
    /**
     * Receives a temparature value from Arduino.
     * @param value The temparature value received from Arduino.
     */
	@Override
	public void receiveMeasurementResult(int value) {
		Log.d(TAG, "received temperature: "+value);
	}
	
	public void startMeasurement() {
		Log.d(TAG, "start Measurement...");
		comm.startMeasurement();
	}
	
	
}	