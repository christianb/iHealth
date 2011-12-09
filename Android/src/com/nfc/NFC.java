package com.nfc;

import java.io.IOException;

import android.nfc.Tag;
import android.nfc.tech.MifareClassic;
import android.util.Log;

public class NFC {
	
	private static final String TAG = "NFC";

	public static void writeTag(Tag tag, String tagText) {
        MifareClassic classic = MifareClassic.get(tag);
        
        try {
            classic.connect();
            classic.authenticateSectorWithKeyA(2, MifareClassic.KEY_DEFAULT);
            //classic.authenticateSectorWithKeyB(1, MifareClassic.KEY_DEFAULT);
            Log.d(TAG, "is connected : "+ classic.isConnected());
            
            byte[] toWrite = new byte[MifareClassic.BLOCK_SIZE];
            for (int i = 0; i<MifareClassic.BLOCK_SIZE; i++) {
            	toWrite[i] = 1;
            }
            //toWrite = "ID:".getBytes(Charset.forName("US-ASCII"));
            
            /*//if the value is less than 16 bytes, fill it with '0'
            byte[] value = tagText.getBytes(Charset.forName("US-ASCII"));
            for (int i=0; i<MifareClassic.BLOCK_SIZE; i++) {
                if (i < value.length) toWrite[i] = value[i];
                else toWrite[i] = 0;
            }*/
            
            //classic.writeBlock(8, toWrite);
            
            //toWrite = "00:06:66:05:07:4D0000".getBytes(Charset.forName("US-ASCII"));
            toWrite[0] = 0x00;
            toWrite[1] = 0x06;
            toWrite[2] = 0x66;
            toWrite[3] = 0x05;
            toWrite[4] = 0x07;
            toWrite[5] = 0x4D;
            toWrite[6] = 0x00;
            toWrite[7] = 0x00;
            toWrite[8] = 0x00;
            toWrite[9] = 0x00;
            toWrite[10] = 0x00;
            toWrite[11] = 0x00;
            toWrite[12] = 0x00;
            toWrite[13] = 0x00;
            toWrite[14] = 0x00;
            toWrite[15] = 0x00;
            classic.writeBlock(9, toWrite);
        } catch (IOException e) {
        	
        } finally {
        
        	try {
				classic.close();
			} catch (IOException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
        }
    }
    
    public static byte[] readTag(Tag tag) {
        MifareClassic mifare = MifareClassic.get(tag);
        try {
            mifare.connect();
            mifare.authenticateSectorWithKeyA(2, MifareClassic.KEY_DEFAULT);
            byte[] payload = mifare.readBlock(9);
            return payload;
            //return bytesToHex(payload);
            
            
            //return new String(payload);
        } catch (IOException e) {
            Log.e(TAG, "IOException while writing MifareClassic message...", e);
        } finally {
            if (mifare != null) {
               try {
                   mifare.close();
               }
               catch (IOException e) {
                   Log.e(TAG, "Error closing tag...", e);
               }
            }
        }
        return null;
    }
}
