package ihealth.webservice;

import ihealth.utils.Sha1;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpUriRequest;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpParams;
import org.apache.http.protocol.HTTP;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

public class RestJsonClient {
	
	private final static String TAG = "RestJsonClient";
	
	private final static String HOST = "http://titania.f4.htw-berlin.de";
	
	public static JSONObject loginPOST(String pUser, String pPassword) {
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
        
        List<NameValuePair> values = new ArrayList<NameValuePair>(2);
        values.add(new BasicNameValuePair("username",pUser));
        values.add(new BasicNameValuePair("hash", hash));
        
        try {
			post.setEntity(new UrlEncodedFormEntity(values, HTTP.UTF_8));
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
        
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
	
	public static JSONObject getPatientData(String pPatientRFID) {
		HttpClient httpclient = new DefaultHttpClient();
		
		String path = "/patients/"+pPatientRFID;
		
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
	
	/**
	 * 
	 * @param pPatientId
	 * @param pType
	 * @param pValue
	 * @param pNote
	 * @param pUserId ID des Arztes oder der Krankenschwester
	 * @return
	 */
	public static JSONObject createMeasurement(String pPatientId, String pType, String pValue, String pNote, String pUserId) {
		HttpClient httpclient = new DefaultHttpClient();
		HttpPost post = new HttpPost();
		
		String path = "/measurements";
        try {
			post.setURI(new URI(HOST+path));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
        
        List<NameValuePair> values = new ArrayList<NameValuePair>(2);
        values.add(new BasicNameValuePair("type",pType));
        values.add(new BasicNameValuePair("value", pValue));
        values.add(new BasicNameValuePair("patientId",pPatientId));
        values.add(new BasicNameValuePair("note", pNote));
        values.add(new BasicNameValuePair("userId", pUserId));

        try {
			post.setEntity(new UrlEncodedFormEntity(values, HTTP.UTF_8));
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
        
        return execute(httpclient, post);
	}

	public static JSONObject getMeasurement(String pPatientId, String pType, String pLimit) {
		HttpClient httpclient = new DefaultHttpClient();
		
		String path = "/measurements/";
		
		// Prepare a request object
        HttpGet get = new HttpGet();
        try {
			get.setURI(new URI(HOST+path));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}

        HttpParams params = new BasicHttpParams();
        params.setParameter("type", pType);
        params.setParameter("patientId", pPatientId);
        params.setParameter("limit", pLimit);
        get.setParams(params);
       
        return execute(httpclient, get);
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