package com.example.db2;

import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.VolleyError;
import java.util.HashMap;
import java.util.Map;

public class EditAllRequest extends StringRequest{
    private Map<String, String> args;
    private static Response.ErrorListener err = new Response.ErrorListener(){
        @Override
        public void onErrorResponse(VolleyError error){
            Log.d("please","Error listener response: " + error.getMessage());
        }
    };

    public EditAllRequest(String OldEmail, String NewEmail, String password, String phone, String url, Response.Listener<String> listener){
        super(Method.POST, url, listener, err);
        args = new HashMap<String, String>();
        //Passes these variables to PHP in method POST
        args.put("OldEmail", OldEmail);
        args.put("NewEmail", NewEmail);
        args.put("password", password);
        args.put("phone", phone);

    }

    @Override
    protected Map<String, String> getParams() throws AuthFailureError {
        return args;
    }
}