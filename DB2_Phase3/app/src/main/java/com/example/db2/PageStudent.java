package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

public class PageStudent extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_page_student);
        //Set the buttons and text to be equal to the actual values from the activity's layout
        TextView tvName = (TextView) findViewById(R.id.tvName);
        TextView tvEmail = (TextView) findViewById(R.id.tvEmail);
        TextView tvPassword = (TextView) findViewById(R.id.tvPassword);
        TextView tvPhone = (TextView) findViewById(R.id.tvPhone);
        Button editEmailButton = (Button) findViewById(R.id.editEmailButton);
        Button editPhoneButton = (Button) findViewById(R.id.editPhoneButton);
        Button editPasswordButton = (Button) findViewById(R.id.editPasswordButton);
        Button meetingMembers = (Button) findViewById(R.id.meetingMembers);
        Button studyMaterials = (Button) findViewById(R.id.studyMaterials);
        final LinearLayout userLayout = (LinearLayout) findViewById(R.id.userLayout);
        //Gets info passed from last intent
        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "parent";

        //Edit button Listener, Passing the info needed and creating new intent
        editEmailButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editStudentEmailIntent = new Intent(PageStudent.this, EditEmailStudent.class);
                editStudentEmailIntent.putExtra("email", email);
                editStudentEmailIntent.putExtra("password", password);
                editStudentEmailIntent.putExtra("phone", phone);
                editStudentEmailIntent.putExtra("name", name);
                editStudentEmailIntent.putExtra("user", user);
                PageStudent.this.startActivity(editStudentEmailIntent);
            }
        });
        //Edit button Listener, Passing the info needed and creating new intent
        editPhoneButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editStudentPhoneIntent = new Intent(PageStudent.this, EditPhoneStudent.class);
                editStudentPhoneIntent.putExtra("email", email);
                editStudentPhoneIntent.putExtra("password", password);
                editStudentPhoneIntent.putExtra("phone", phone);
                editStudentPhoneIntent.putExtra("name", name);
                editStudentPhoneIntent.putExtra("user", user);
                PageStudent.this.startActivity(editStudentPhoneIntent);
            }
        });
        //Edit button Listener, Passing the info needed and creating new intent
        editPasswordButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editStudentPasswordIntent = new Intent(PageStudent.this, EditPasswordStudent.class);
                editStudentPasswordIntent.putExtra("email", email);
                editStudentPasswordIntent.putExtra("password", password);
                editStudentPasswordIntent.putExtra("phone", phone);
                editStudentPasswordIntent.putExtra("name", name);
                editStudentPasswordIntent.putExtra("user", user);
                PageStudent.this.startActivity(editStudentPasswordIntent);
            }
        });

        meetingMembers.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent displayMeetingMembers = new Intent(PageStudent.this, DisplayingMeetingMembers.class);
                displayMeetingMembers.putExtra("email", email);
                PageStudent.this.startActivity(displayMeetingMembers);
            }
        });
        studyMaterials.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent DisplayingStudyMaterials = new Intent(PageStudent.this, DisplayingStudyMaterials.class);
                DisplayingStudyMaterials.putExtra("email", email);
                PageStudent.this.startActivity(DisplayingStudyMaterials);
            }
        });
        Button MeetingJoinSelection = (Button) findViewById(R.id.JoinMeetingButton);
        MeetingJoinSelection.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent MeetingJoinSelection = new Intent(PageStudent.this, MeetingJoinSelection.class);
                MeetingJoinSelection.putExtra("email", email);
                MeetingJoinSelection.putExtra("password", password);
                MeetingJoinSelection.putExtra("phone", phone);
                MeetingJoinSelection.putExtra("name", name);
                MeetingJoinSelection.putExtra("user", user);
                PageStudent.this.startActivity(MeetingJoinSelection);
            }
        });
        Button MeetingQuitSelection = (Button) findViewById(R.id.QuitMeetingButton);
        MeetingQuitSelection.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent MeetingQuitSelection = new Intent(PageStudent.this, MeetingQuitSelection.class);
                MeetingQuitSelection.putExtra("email", email);
                MeetingQuitSelection.putExtra("password", password);
                MeetingQuitSelection.putExtra("phone", phone);
                MeetingQuitSelection.putExtra("name", name);
                MeetingQuitSelection.putExtra("user", user);
                PageStudent.this.startActivity(MeetingQuitSelection);
            }
        });

        //Set the values of the text boxes
        String title = name + "'s Page";
        tvName.setText(title);
        tvEmail.setText(email);
        tvPhone.setText(phone);


    }
}