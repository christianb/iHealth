package ihealth.arduino;

public interface MessageReceiver {

	void receiveMeasurementResult(float value);
	
	void startRemoteMeasurement();
}
