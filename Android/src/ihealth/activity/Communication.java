package ihealth.activity;
import java.util.ArrayList;
import java.util.List;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.util.Log;
import at.abraxas.amarino.Amarino;
import at.abraxas.amarino.AmarinoIntent;

public class Communication {

	private final String mDeviceAddress;
	private final Context mContext;
	//private final BroadcastReceiver mReceiver;
	
	private ArduinoReceiver arduinoReceiver = new ArduinoReceiver();
	
	private boolean isConnected = false;
	
	private List<MessageReceiver> mMessageReceivers = null;
	
	public Communication(Context pContext, String pDevice_Address) {
		mDeviceAddress = pDevice_Address;
		mContext = pContext;
		mMessageReceivers = new ArrayList<MessageReceiver>();
		//mReceiver = pReceiver;
	}
	
	public void registerCallback(MessageReceiver mr) {
		mMessageReceivers.add(mr);
	}
	
	public void unregisterCallback(MessageReceiver mr) {
		mMessageReceivers.remove(mr);
	}
	
	public void notifyCallbacks(int value) {
		for (MessageReceiver m : mMessageReceivers) {
			m.receiveMeasurementResult(value);
		}
	}
	
	/**
     * Connect to a Bluetooth Device
     * @param pDevice_Address Set the address of the Bluetooth device.
     */
    public void connectToArduino() {
    	// in order to receive broadcasted intents we need to register our receiver
    	mContext.registerReceiver(arduinoReceiver, new IntentFilter(AmarinoIntent.ACTION_RECEIVED));
    	mContext.registerReceiver(arduinoReceiver, new IntentFilter(AmarinoIntent.ACTION_CONNECTED));
    	
    	// TODO Add a local receiver, to check connection state
    	// TODO add callback wich have to be registered to receive messages!
    			
    	
    	// this is how you tell Amarino to connect to a specific BT device from within your own code
    	Amarino.connect(mContext, mDeviceAddress);
    }
    
    /**
     * Disconnect from a Bluetooth Device.
     * @param pDevice_Address
     */
    public void disconnectFromArduino() {
    	// if you connect in onStart() you must not forget to disconnect when your app is closed
    	Amarino.disconnect(mContext, mDeviceAddress);
    			
    	// do never forget to unregister a registered receiver
    	mContext.unregisterReceiver(arduinoReceiver);
    }
    
    public void sendInteger(int value, char flag) {
    	Amarino.sendDataToArduino(mContext, mDeviceAddress, flag, value);
    }
    
    public void sendString(String value, char flag) {
    	Amarino.sendDataToArduino(mContext, mDeviceAddress, flag, value);
    }
    
    /**
     * 
     * @param pDuration
     * Flag: 'M' calls startMeasurement at Arduino.
     * The value is the duration the Arduino must do the measurement.
     */
    public void startMeasurement() {
    	sendInteger(0, 'M');
    }
    
    /**
     * ArduinoReceiver is responsible for catching broadcasted Amarino
     * events.
     * 
     * It extracts data from the intent and updates the graph accordingly.
     */
    public class ArduinoReceiver extends BroadcastReceiver {
    	
    	private final static String TAG = "ArduinoReceiver";

    	@Override
    	public void onReceive(Context context, Intent intent) {
    		if (intent.filterEquals(new Intent(AmarinoIntent.ACTION_CONNECTED))) {
    			Log.d(TAG, "connection established");
    			isConnected = true;
    		}
    		
    		if (intent.filterEquals(new Intent(AmarinoIntent.ACTION_DISCONNECTED))) {
    			Log.d(TAG, "disconnected");
    			isConnected = false;
    		}
    		
    		//String data = null;
    		String data;
    		
    		// the device address from which the data was sent, we don't need it here but to demonstrate how you retrieve it
    		final String address = intent.getStringExtra(AmarinoIntent.EXTRA_DEVICE_ADDRESS);
    		
    		// the type of data which is added to the intent
    		final int dataType = intent.getIntExtra(AmarinoIntent.EXTRA_DATA_TYPE, -1);
    		
    		// we expect an array of integer
    		if (dataType == AmarinoIntent.STRING_EXTRA){
    			data = intent.getStringExtra(AmarinoIntent.EXTRA_DATA);
    			
    			//if (data != null){
    				//try {
    					// since we know that our string value is an int number we can parse it to an integer
    					//final int sensorReading = Integer.parseInt(data);
    					Log.d(TAG, "Sensor Reading: "+data);
    					//notifyCallbacks(data);
    					//mGraph.addDataPoint(sensorReading);
    				//} 
    				//catch (NumberFormatException e) { /* oh data was not an integer */ }
    			//}
    		}
    	}
    }
}
