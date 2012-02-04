package com.activities;

import com.activities.R;

import ihealth.utils.Patient;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

/** Patientendetails: Name, Geburtstag, etc. */
public class PatientDetailView extends iHealthSuperActivity {
	
	private TextView mBirthday;
	private TextView mBloodGroup;
	private TextView mWeight;
	private TextView mSize;
	private TextView mStreet;
	private TextView mCity;
	private TextView mZipCode;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.patient_detail);
		
		mBirthday = (TextView) findViewById(R.id.patient_details_content_birthdate);
		mBloodGroup = (TextView) findViewById(R.id.patient_details_content_blutgruppe);
		mWeight = (TextView) findViewById(R.id.patient_details_content_weight);
		mSize = (TextView) findViewById(R.id.patient_details_content_size);
		mStreet = (TextView) findViewById(R.id.patient_details_content_street);
		mCity = (TextView) findViewById(R.id.patient_details_content_city);
		mZipCode = (TextView) findViewById(R.id.patient_details_content_zipcode);
		
		
		
		// TODO make members of views
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_headline));
		setFontSegoeWP((TextView) findViewById(R.id.patient_details_image_text_1));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_image_text_2));
		setFontSegoeWPLight(mBirthday);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_birthday_description));
		setFontSegoeWPLight(mBloodGroup);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_blutgruppe_description));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_checkin_date));
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_checkin_date_description));
		//setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_name));
		//setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_name_description));
		setFontSegoeWPLight(mWeight);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_weight_description));
		setFontSegoeWPLight(mSize);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_size_description));
		setFontSegoeWPLight(mStreet);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_street_description));
		setFontSegoeWPLight(mZipCode);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_zipcode_description));
		setFontSegoeWPLight(mCity);
		setFontSegoeWPLight((TextView) findViewById(R.id.patient_details_content_city_description));
		
		// Restore preferences
		//SharedPreferences sp = getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
		
		setContent(Patient.getInstance());
		
	}
	
	@Override
	public void readNewPatient(Patient p) {
		setContent(p);
	}
	
	private void setContent(Patient p) {
		
		TextView image_text = (TextView) findViewById(R.id.patient_details_image_text_2);
		image_text.setText(p.getFirstname()+" "+p.getLastname());
		
		//TextView name = (TextView) findViewById(R.id.patient_details_content_name);
		//name.setText(p.getFirstname()+" "+p.getLastname());
		
		mBirthday.setText(p.getBirthday());
		mBloodGroup.setText(p.getBloodGroup());
		mSize.setText(p.getSize());
		mWeight.setText(p.getWeight());
		mStreet.setText(p.getStreet());
		mZipCode.setText(p.getZipCode());
		mCity.setText(p.getCity());
		
		TextView sex = (TextView) findViewById(R.id.patient_details_image_text_1);
		if (p.getSex().equalsIgnoreCase("male")) {
			sex.setText("Herr");
		} else {
			sex.setText("Frau");
		}
		
		ImageView image = (ImageView) findViewById(R.id.patient_details_image); 
		int i = new Integer(p.getID()).intValue();
		switch (i) {
			
			case 2: image.setImageResource(R.drawable.patient_2_small);
				break;
			case 3: image.setImageResource(R.drawable.patient_3_small);
				break;
			case 4: image.setImageResource(R.drawable.patient_4_small);
				break;
			default: image.setImageResource(R.drawable.patient_1_small);
		}
		
	}
}
