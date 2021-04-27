package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.Display;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class DisplayingMeetingMembers extends AppCompatActivity {


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_displaying_meeting_members);


        TextView membersList = (TextView) findViewById(R.id.membersList);
        Intent intent = getIntent();
        final String email = intent.getStringExtra("email");
        final LinearLayout userLayout = (LinearLayout) findViewById(R.id.userLayout);

        //Confirm button listener

        Response.Listener<String> responseListener = new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    Log.d("MeetingMembers", response);
                    JSONObject jsonResponse = new JSONObject(response);
                    int i = 0;

                    //This section needs to be updated for the mentors and mentees input
                    while(jsonResponse.has(Integer.toString(i) + "cid")){
                        Log.d("Gotten Response","Time for Action");
                        String cName = jsonResponse.getString(Integer.toString(i) + "cName");
                        String cEmail = jsonResponse.getString(Integer.toString(i) + "cEmail");
                        String cPhone = jsonResponse.getString(Integer.toString(i) + "cPhone");

                        String temp = "Name: " + cName;
                        String temp2 = "Email: " + cEmail + ", Phone: " + cPhone;
                        TextView userInfo = new TextView(DisplayingMeetingMembers.this);
                        TextView userInfo2 = new TextView(DisplayingMeetingMembers.this);
                        userInfo.setText(temp);
                        userInfo2.setText(temp2);
                        userLayout.addView(userInfo);
                        userLayout.addView(userInfo2);
                        userLayout.addView(new TextView(DisplayingMeetingMembers.this));
                        i++;
                    }
                } catch (JSONException e) {
                    // should not reach here
                    Log.d("whatHappened", response);
                    e.printStackTrace();
                }
            }
        };

        DisplayingMeetingMembersRequest DisplayMMReq = new DisplayingMeetingMembersRequest(email, getString(R.string.url) + "getMeetingMembers.php", responseListener);
        RequestQueue queue = Volley.newRequestQueue(DisplayingMeetingMembers.this);
        queue.add(DisplayMMReq);






    }
}