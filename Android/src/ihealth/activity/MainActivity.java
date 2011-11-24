package ihealth.activity;

import ihealth.activity.R;
import ihealth.activity.R.layout;

import org.json.JSONObject;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;

public class MainActivity extends Activity {
	
	private final static String TAG = "MAGWActivity";
	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
        
        //JSONObject jObject = RestJsonClient.login("Testa", "Testa");
        //JSONObject jObject = RestJsonClient.getPatientData(4);
        JSONObject jObject = RestJsonClient.createReport();
        Log.d(TAG, jObject.toString());
    }
}	