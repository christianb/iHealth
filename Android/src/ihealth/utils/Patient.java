package ihealth.utils;

import android.content.SharedPreferences;

public class Patient {
	
	// KONSTANTEN:
	// Allgemeine Informationen
	public static final String FIRSTNAME = "firstname";
	public static final String LASTNAME = "lastname";
	public static final String BIRTHDAY = "birthday"; // Fehlt noch.
	
	// Vital Attribute
	public static final String SIZE = "size";
	public static final String WEIGHT = "weight";
	public static final String BLOOD_GROUP = "bloodGroup";
	
	// Adresse 
	public static final String STREET = "street";
	public static final String ZIPCODE = "zipcode";
	public static final String CITY = "city";
	
	
	// MEMBER
	private String mFirstname;
	private String mLastname;
	private String mBirthday;
	
	private String mSize;
	private String mWeight;
	private String mBloodGroup;
	
	private String mStreet;
	private String mZipCode;
	private String mCity;
	
	private static Patient instance;
	
	private Patient () {}
	
	public static Patient getInstance() {
		if (instance == null) {
			instance = new Patient();
		}
		
		return instance;
	}
	
	public Patient create(SharedPreferences sp) {
		mFirstname = sp.getString(FIRSTNAME, "...");
		mLastname = sp.getString(LASTNAME, "...");
		mBirthday = sp.getString(BIRTHDAY, "...");
		
		mSize = sp.getString(SIZE, "...");
		mWeight = sp.getString(WEIGHT, "...");
		mBloodGroup = sp.getString(BLOOD_GROUP, "...");
		
		mStreet = sp.getString(STREET, "...");
		mZipCode = sp.getString(ZIPCODE, "...");
		mCity = sp.getString(CITY, "...");
		
		return instance;
	}
	
	public String getFirstname() {
		return mFirstname;
	}

	public String getLastname() {
		return mLastname;
	}

	public String getBirthday() {
		return mBirthday;
	}

	public String getSize() {
		return mSize;
	}

	public String getWeight() {
		return mWeight;
	}

	public String getBloodGroup() {
		return mBloodGroup;
	}

	public String getStreet() {
		return mStreet;
	}

	public String getZipCode() {
		return mZipCode;
	}

	public String getCity() {
		return mCity;
	}
}
