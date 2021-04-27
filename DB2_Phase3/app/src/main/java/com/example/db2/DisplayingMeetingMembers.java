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
                    Log.d("TestMeetingMembers", response);
                    JSONObject jsonResponse = new JSONObject(response);
                    int i = 0;
                    Log.d("In Try","Awaiting response!");
                    //This section needs to be updated for the mentors and mentees input
                    while(jsonResponse.has(Integer.toString(i) + "cid")){
                        Log.d("Here is Response","Time for Action");
                        String Name = jsonResponse.getString(Integer.toString(i) + "Name");
                        Log.d("Here Name: ",Name);
                        String Email = jsonResponse.getString(Integer.toString(i) + "Email");
                        Log.d("Here Email: ",Email);
                        String Meeting = jsonResponse.getString(Integer.toString(i) + "Meeting");
                        Log.d("Here MeetID: ",Meeting);
                        String Status = jsonResponse.getString(Integer.toString(i) + "Status");
                        Log.d("Here Status: ",Status);

                        String temp = "Name: " + Name + " Email: " + Email;
                        String temp2 = Status + ", Meeting #" + Meeting;
                        Log.d("Location: ","PostStringTemps");
                        TextView userInfo = new TextView(DisplayingMeetingMembers.this);
                        TextView userInfo2 = new TextView(DisplayingMeetingMembers.this);
                        Log.d("Location: ","PostTextView");
                        userInfo.setText(temp);
                        Log.d("Location: ","PostUserInfo1");
                        userInfo2.setText(temp2);
                        Log.d("Location: ","PostUserInfo2");
                        userLayout.addView(userInfo);
                        Log.d("Location: ","PostAddview1");
                        userLayout.addView(userInfo2);
                        Log.d("Location: ","PreFinal AddView");
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
        Log.d("At end","Over");
        DisplayingMeetingMembersRequest DisplayMMReq = new DisplayingMeetingMembersRequest(email, getString(R.string.url) + "getMeetingMembers.php", responseListener);
        RequestQueue queue = Volley.newRequestQueue(DisplayingMeetingMembers.this);
        queue.add(DisplayMMReq);






    }
}