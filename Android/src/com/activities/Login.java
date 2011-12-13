package com.activities;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

/** Welcome + Login */
public class Login extends iHealthSuperActivity {

	private static final String TAG = "Login";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);
		
		Button doLogin = (Button) findViewById(R.id.login_button);
		doLogin.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Log.d(TAG, "click button : login");
				
				Intent intent = new Intent(Login.this, MainMenu.class);
				startActivity(intent);
			}
		});
		
		setFontSegoeWPLight((TextView) findViewById(R.id.login_headline));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_username_info));
		setFontSegoeWPLight((TextView) findViewById(R.id.login_password_info));
	}
}
