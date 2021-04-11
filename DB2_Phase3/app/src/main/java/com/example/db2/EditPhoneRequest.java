package com.example.db2;

import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.VolleyError;
import java.util.HashMap;
import java.util.Map;

public class EditPhoneRequest extends StringRequest{
    private Map<String, String> args;
    private static Response.ErrorListener err = new Response.ErrorListener(){
        @Override
        public void onErrorResponse(VolleyError error){
            Log.d("please","Error listener response: " + error.getMessage());
        }
    };

    public EditPhoneRequest(String NPhone,String Email, String url, Response.Listener<String> listener){
        super(Method.POST, url, listener, err);
        args = new HashMap<String, String>();
        //Passes these variables to php file that is specified by URL via POST
        args.put("NewPhone", NPhone);
        args.put("Email", Email);
    }

    @Override
    protected Map<String, String> getParams() throws AuthFailureError {
        return args;
    }
}