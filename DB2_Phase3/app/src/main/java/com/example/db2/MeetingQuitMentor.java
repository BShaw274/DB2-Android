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

public class MeetingQuitMentor extends AppCompatActivity {
    //Initializes the editTexts and Buttons
    EditText MeetID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meeting_quit_mentor);
        //Gets info passed from previous intent
        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "student";
        //Set the buttons and text to be equal to the actual values from the activity's layout-
        MeetID = (EditText) findViewById(R.id.MeetingID);
        Button QuitSingleButton = (Button) findViewById(R.id.QuitSingle);
        Button QuitRecurringButton = (Button) findViewById(R.id.QuitRecurring);

        //Single button listener
        QuitSingleButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String MeetingID = MeetID.getText().toString();
                Log.d("Update TEst#","OnClick Single: ");
                if (MeetingID.matches("")) {
                    Toast.makeText(MeetingQuitMentor.this, "You did not enter a MeetingID", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("Trying Quit Single : ", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                Log.d("In IF stmt Single","In if ");
                                //Create New intent to go back to he PageParent after updating Email
                                Intent intent = new Intent(MeetingQuitMentor.this, PageStudent.class);
                                //Passes values to new activity
                                intent.putExtra("name", name );
                                intent.putExtra("email", email);
                                intent.putExtra("password", password);
                                intent.putExtra("phone", phone);

                                MeetingQuitMentor.this.startActivity(intent);
                            } else{
                                Log.d("Else stmt","In Else stmt !: ");
                                AlertDialog.Builder builder = new AlertDialog.Builder(MeetingQuitMentor.this);
                                builder.setMessage("Meeting ID is Invalid, make sure you entered a valid meeting ID that you can Join as Mentor.").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            AlertDialog.Builder builder = new AlertDialog.Builder(MeetingQuitMentor.this);
                            builder.setMessage("Invalid Data, Deletion Not Possible").setNegativeButton("Retry", null).create().show();
                            e.printStackTrace();
                        }

                    }
                };
                Log.d("Requests","Request the php single");

                //Here we use the request format to access the correct php file while passing the correct variables
                MeetingRequest MeetingQuitRequest = new MeetingRequest(email, MeetingID, getString(R.string.url) + "RemoveMentorSingle.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(MeetingQuitMentor.this);
                queue.add(MeetingQuitRequest);


            }
        });
        //listener done

        //Recurring button listener
        QuitRecurringButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String MeetingID = MeetID.getText().toString();
                Log.d("Update Test","Recurring: ");
                if (MeetingID.matches("")) {
                    Toast.makeText(MeetingQuitMentor.this, "You did not enter a MeetingID", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("Trying Recurring: ", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                Log.d("In IF stmt","In if ");
                                //Create New intent to go back to he PageParent after updating Email
                                Intent intent = new Intent(MeetingQuitMentor.this, PageStudent.class);
                                //Passes values to new activity
                                intent.putExtra("name", name );
                                intent.putExtra("email", email);
                                intent.putExtra("password", password);
                                intent.putExtra("phone", phone);

                                MeetingQuitMentor.this.startActivity(intent);
                            } else{
                                Log.d("Else Recurr stmt","In Else stmt !: ");
                                AlertDialog.Builder builder = new AlertDialog.Builder(MeetingQuitMentor.this);
                                builder.setMessage("Meeting ID is Invalid, make sure you entered a valid meeting ID that you can Quit as Mentor.").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            Log.d("Catch Recurr stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                Log.d("Requests","Request the phpRecurring");

                //Here we use the request format to access the correct php file while passing the correct variables
                MeetingRequest MeetingQuitRequest = new MeetingRequest(email, MeetingID, getString(R.string.url) + "RemoveMentorRecurring.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(MeetingQuitMentor.this);
                queue.add(MeetingQuitRequest);

            }
        });
        //listener done


    }
}