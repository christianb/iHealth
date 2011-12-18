package com.activities;

import org.json.JSONException;
import org.json.JSONObject;

import ihealth.webservice.RestJsonClient;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
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
		
		Button doLogin = (Button) findViewById(R.id.login_button);
		doLogin.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click button : login");
				
				JSONObject jObject = RestJsonClient.loginPOST(username.getText().toString(), password.getText().toString());
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
				
				Log.d(TAG, statusmessage);
				int iStatuscode = new Integer(sStatuscode).intValue();
				
				if (iStatuscode == 200) {
					Intent intent = new Intent(Login.this, MainMenu.class);
					startActivity(intent);
				}
				
				if (iStatuscode == 404) {
					Toast.makeText(Login.this, statusmessage, Toast.LENGTH_SHORT).show();
				}
				
				
			}
		});
		
			
		
		setFontSegoeWPLight(password);
		setFontSegoeWPLight(username);
		setFontSegoeWPLight((TextView) findViewById(R.id.login_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_username_info));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_password_info));
		
		
	}
}
