package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class DisplayingStudyMaterials extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_displaying_study_materials);

        TextView studyMats = (TextView) findViewById(R.id.studymats);
        Intent intent = getIntent();
        final String email = intent.getStringExtra("email");
        final LinearLayout userLayout = (LinearLayout) findViewById(R.id.studyLayout);

        Response.Listener<String> responseListener = new Response.Listener<String>() {
            public void onResponse(String response) {
                try {
                    Log.d("studyMaterials", response);
                    JSONObject jsonResponse = new JSONObject(response);
                    int i = 0;
                    while(jsonResponse.has(Integer.toString(i) + "cid")){
                        Log.d("Gotten Response","Time for Action");
                        String cTitle = jsonResponse.getString(Integer.toString(i) + "cTitle");
                        String cAuthor = jsonResponse.getString(Integer.toString(i) + "cAuthor");
                        String cType = jsonResponse.getString(Integer.toString(i) + "cType");
                        String cUrl = jsonResponse.getString(Integer.toString(i) + "cUrl");
                        String cAssigned_date = jsonResponse.getString(Integer.toString(i) + "cAssigned_date");
                        String cNotes = jsonResponse.getString(Integer.toString(i) + "cNotes");

                        String temp = "Title: " + cTitle + ", Author: "+ cAuthor + ", Type: " + cType + ", URL: " + cUrl + ", Assigned Date: " + cAssigned_date + ", Notes " + cNotes;
                        TextView studyMats = new TextView(DisplayingStudyMaterials.this);
                        studyMats.setText(temp);
                        userLayout.addView(studyMats);
                        userLayout.addView(new TextView(DisplayingStudyMaterials.this));

                        i++;
                    }
                } catch (JSONException e) {
                    // should not reach here
                    Log.d("whatHappened", response);
                    e.printStackTrace();
                }
            }
        };
        Log.d("Request sent" , "Attempting the PHP code");
        DisplayingStudyMaterialsRequest DisplaySM = new DisplayingStudyMaterialsRequest(email, getString(R.string.url) + "getStudyMaterials.php", responseListener);
        RequestQueue queue = Volley.newRequestQueue(DisplayingStudyMaterials.this);
        queue.add(DisplaySM);
    }
}