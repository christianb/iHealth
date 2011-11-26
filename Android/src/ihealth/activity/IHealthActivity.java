package ihealth.activity;

import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;

import ihealth.activity.R;
import ihealth.activity.R.layout;

import org.json.JSONObject;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class IHealthActivity extends Activity implements MessageReceiver {
	
	private final static String TAG = "IHealthActivity";
	
	private Communication comm;
	
	private Button startMeasurement;
	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
        //JSONObject jObject = RestJsonClient.login("Testa", "Testa");
        //JSONObject jObject = RestJsonClient.getPatientData(4);
        //JSONObject jObject = RestJsonClient.createReport();
        //Log.d(TAG, jObject.toString());
        
				Log.d(TAG, "Sha1: " + Sha1.getHash("Hallo Welt"));

        
        startMeasurement = (Button) findViewById(R.id.startMeasurement);
        
        startMeasurement.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				startMeasurement();
			}
		});
        
        comm = new Communication(this, "00:06:66:05:07:4D");
        comm.connectToArduino();
        comm.registerCallback(this);
    }
    
    @Override
	protected void onDestroy() {
		comm.disconnectFromArduino();
		comm.unregisterCallback(this);
		
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