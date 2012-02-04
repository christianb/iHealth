package com.activities;

import ihealth.webservice.RestJsonClient;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

/** Welcome + Login */
public class Login extends iHealthSuperActivity {

	private static final String TAG = "Login";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);
		
		final TextView password = (TextView) findViewById(R.id.login_password_edit);
		final TextView username = (TextView) findViewById(R.id.login_username_edit);
		
		password.setText("astronaut");
		username.setText("christian");	
		
		RelativeLayout doLogin = (RelativeLayout) findViewById(R.id.login_button);
		doLogin.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click button : login");
				
				if (isOnline()) {
					Log.d(TAG, "ist online");
					JSONObject jObject = RestJsonClient.login(username.getText().toString(), password.getText().toString());
					Log.d(TAG, "Empfangen: " + jObject.toString());
					String sStatuscode = "";
					String statusmessage = "";
					String user_id = "-1";
					
					try {
						sStatuscode = jObject.get("statuscode").toString();
						statusmessage = jObject.get("statusmessage").toString();
						user_id = jObject.getJSONObject("response").getString("userId");
						
						Log.d(TAG, "statuscode = "+ sStatuscode);
						Log.d(TAG, "User ID (Arzt): "+user_id);
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
					
					Log.d(TAG, statusmessage);
					int iStatuscode = new Integer(sStatuscode).intValue();
					
					if (iStatuscode == 200) {
						SharedPreferences settings = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
						SharedPreferences.Editor editor = settings.edit();
						editor.putString("doctorID", user_id);
						
						Intent intent = new Intent(Login.this, MainMenu.class);
						startActivity(intent);
						
						
					}
					
					if (iStatuscode == 404) {
						Toast.makeText(Login.this, statusmessage, Toast.LENGTH_SHORT).show();
					}
					
				} else {
					Log.d(TAG, "nicht online");
					// is not online
					Toast.makeText(Login.this, "Keine Verbindung zum Netzwerk!", Toast.LENGTH_SHORT).show();
				}
				
				
			}
		});
		
			
		setFontSegoeWPLight( (TextView) findViewById(R.id.headline_welcome_2));
		setFontSegoeWPLight( (TextView) findViewById(R.id.headline_welcome_3));
		setFontSegoeWPLight( (TextView) findViewById(R.id.headline_welcome_4));
		setFontSegoeWP( (TextView) findViewById(R.id.headline_welcome_1));
		
		setFontSegoeWPLight(password);
		setFontSegoeWPLight(username);
		setFontSegoeWPLight((TextView) findViewById(R.id.login_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_username_info));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_password_info));
		
	}
	
	public boolean isOnline() {
		 ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		 NetworkInfo netInfo = cm.getActiveNetworkInfo();
		 if (netInfo != null && netInfo.isConnectedOrConnecting()) {
		        return true;
		 }
		 
		 return false;
	}
}
