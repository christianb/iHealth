package com.activities;

import java.util.List;

import android.app.Activity;
import android.app.PendingIntent;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.IntentFilter.MalformedMimeTypeException;
import android.graphics.Typeface;
import android.nfc.NfcAdapter;
import android.nfc.tech.MifareClassic;
import android.nfc.tech.NdefFormatable;
import android.nfc.tech.NfcA;
import android.os.Bundle;
import android.widget.TextView;

public class iHealthSuperActivity extends Activity {

	protected NfcAdapter mAdapter;
	protected PendingIntent pendingIntent;
	protected IntentFilter[] intentFiltersArray;
	protected String[][] techListsArray;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
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
}
