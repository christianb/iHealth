package ihealth.webservice;

import ihealth.utils.Sha1;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URI;
import java.net.URISyntaxException;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpUriRequest;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.protocol.HTTP;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

public class RestJsonClient {
	
	private final static String TAG = "RestJsonClient";
	
	private final static String HOST = "http://titania.f4.htw-berlin.de";
	
	public static JSONObject login(String pUser, String pPassword) {
		HttpClient httpclient = new DefaultHttpClient();
		
		// hash the password
		String hash = Sha1.getHash(pPassword);
		
		// set the path
		String path = "/login/";
		
		// Prepare a request object
        HttpPost post = new HttpPost();
        try {
			post.setURI(new URI(HOST+path));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
        
        // Create JSON
        JSONObject jo = new JSONObject();
        try {
			jo.put("username", pUser);
			jo.put("hash", hash);
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        
        Log.d(TAG, "json to send: "+jo.toString());
        
        StringEntity se = null;
        
        try {
			se = new StringEntity(jo.toString(), HTTP.UTF_8);
			se.setContentType("application/json");
		} catch (UnsupportedEncodingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        
        //httppost.setHeader("Content-Type","application/soap+xml;charset=UTF-8");
        post.setEntity(se); 
        
        return execute(httpclient, post);
	}

	private static JSONObject execute(HttpClient httpclient, HttpUriRequest httpget) {
		// Execute the request
		    HttpResponse response;

		    JSONObject json = new JSONObject();

		    try {
		        response = httpclient.execute(httpget);

		        HttpEntity entity = response.getEntity();

		        if (entity != null) {

		            // A Simple JSON Response Read
		            InputStream instream = entity.getContent();
		            String result= convertStreamToString(instream);

		            json=new JSONObject(result);

		            instream.close();
		        }

		    } catch (ClientProtocolException e) {
		        // TODO Auto-generated catch block
		        e.printStackTrace();
		    } catch (IOException e) {
		        // TODO Auto-generated catch block
		        e.printStackTrace();
		    } catch (JSONException e) {
		        // TODO Auto-generated catch block
		        e.printStackTrace();
		    }
		return json;
	}
	
	public static JSONObject getPatientData(int pPatientID) {
		HttpClient httpclient = new DefaultHttpClient();
		
		String path = "/patients/"+pPatientID;
		
		// Prepare a request object
        HttpGet httpget = new HttpGet();
        try {
			httpget.setURI(new URI(HOST+path));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
        
        return execute(httpclient, httpget);
	}
	
	public static JSONObject createReport() {
		HttpClient httpclient = new DefaultHttpClient();
		
		HttpPost httppost = new HttpPost();
		
		String path = "/reports";
        try {
			httppost.setURI(new URI(HOST+path));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
        
        // Make Json
        JSONObject jo = new JSONObject();
        try {
			jo.put("note", "Eine ganz lange Nachricht zu dem Report!");
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        
        Log.d(TAG, "json to send: "+jo.toString());
        
        StringEntity se = null;
        
        try {
			se = new StringEntity(jo.toString(), HTTP.UTF_8);
			se.setContentType("text/xml");
		} catch (UnsupportedEncodingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        
        //httppost.setHeader("Content-Type","application/soap+xml;charset=UTF-8");
        httppost.setEntity(se); 
        
        return execute(httpclient, httppost);
	}
	
	public static JSONObject updateReport() {
		
		return null;
	}
	
	public static JSONObject addMeasurement() {
		
		return null;
	}

    
    /**
     *
     * @param is
     * @return String
     */
    public static String convertStreamToString(InputStream is) {
        BufferedReader reader = new BufferedReader(new InputStreamReader(is));
        StringBuilder sb = new StringBuilder();

        String line = null;
        try {
            while ((line = reader.readLine()) != null) {
                sb.append(line + "\n");
            }
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            try {
                is.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        return sb.toString();
    }

}