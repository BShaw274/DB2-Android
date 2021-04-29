package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class MeetingJoinMentor extends AppCompatActivity {
    //Initializes the editText
    EditText MeetID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meeting_join_mentor);
        //Gets the info passed from last intent
        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "student";
        //Set the buttons and text to be equal to the actual values from the activity's layout
        MeetID = (EditText) findViewById(R.id.MeetingID);
        Button JoinSingleButton = (Button) findViewById(R.id.JoinSingle);
        Button JoinRecurringButton = (Button) findViewById(R.id.JoinRecurring);
        Button ReturnHome = (Button) findViewById(R.id.Return);

//Single button listener
        JoinSingleButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String MeetingID = MeetID.getText().toString();
                Log.d("Update TEst#","OnClick Single: ");
                if (MeetingID.matches("")) {
                    Toast.makeText(MeetingJoinMentor.this, "You did not enter a MeetingID", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("Trying Single : ", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            int i = 0;

                            while(jsonResponse.has(Integer.toString(i) + "cid")){
                                Log.d("In While stmt Single","In if ");
                                String RStatus = jsonResponse.getString(Integer.toString(i) + "cstatus");
                                Log.d("RStatus",RStatus);
                                //Alert User Upon Action Completion
                                AlertDialog.Builder builder = new AlertDialog.Builder(MeetingJoinMentor.this);
                                builder.setMessage(RStatus).setNegativeButton("Continue", null).create().show();

                                i++;
                            }

                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                Log.d("Requests","Request the php single");

                //Uses my EditEmailRequest.java file to pass New and Old Emails to update the account
                MeetingRequest MeetingJoinRequest = new MeetingRequest(email, MeetingID, getString(R.string.url) + "signupmentorsingular.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(MeetingJoinMentor.this);
                queue.add(MeetingJoinRequest);


            }
        });
        //listener done

        //Recurring button listener
        JoinRecurringButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String MeetingID = MeetID.getText().toString();
                Log.d("Update Test","Recurring: ");
                if (MeetingID.matches("")) {
                    Toast.makeText(MeetingJoinMentor.this, "You did not enter a MeetingID", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("Trying Single : ", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            int i = 0;

                            while(jsonResponse.has(Integer.toString(i) + "cid")){
                                Log.d("In While stmt Single","In if ");
                                String RStatus = jsonResponse.getString(Integer.toString(i) + "cstatus");
                                Log.d("RStatus",RStatus);
                                //Alert User Upon Action Completion
                                AlertDialog.Builder builder = new AlertDialog.Builder(MeetingJoinMentor.this);
                                builder.setMessage(RStatus).setNegativeButton("Continue", null).create().show();

                                i++;
                            }
                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                Log.d("Requests","Request the phpRecurring");

                //Here we use the request format to access the correct php file while passing the correct variables
                MeetingRequest MeetingJoinRequest = new MeetingRequest(email, MeetingID, getString(R.string.url) + "signupmentorrecurring.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(MeetingJoinMentor.this);
                queue.add(MeetingJoinRequest);

            }
        });
        //listener done

        //Return Button Listener to return to PageStudent
        ReturnHome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Intent intent = new Intent(MeetingJoinMentor.this, PageStudent.class);
                //Passes values to new activity
                intent.putExtra("name", name );
                intent.putExtra("email", email);
                intent.putExtra("password", password);
                intent.putExtra("phone", phone);

                MeetingJoinMentor.this.startActivity(intent);

            }
        });
        //listener done

    }
}