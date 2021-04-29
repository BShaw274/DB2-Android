package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MeetingQuitSelection extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meeting_quit_selection);
        //Set the buttons and text to be equal to the actual values from the activity's layout
        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "parent";

        //Quit button listener
        Button QuitMentor = (Button) findViewById(R.id.QuitAsMentor);
        QuitMentor.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent QuitAsMentorIntent = new Intent(MeetingQuitSelection.this, MeetingQuitMentor.class);
                QuitAsMentorIntent.putExtra("email", email);
                QuitAsMentorIntent.putExtra("password", password);
                QuitAsMentorIntent.putExtra("phone", phone);
                QuitAsMentorIntent.putExtra("name", name);
                QuitAsMentorIntent.putExtra("user", user);
                MeetingQuitSelection.this.startActivity(QuitAsMentorIntent);
            }
        });
        //Quit button listener
        Button QuitMentee = (Button) findViewById(R.id.QuitAsMentee);
        QuitMentee.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent QuitAsMenteeIntent = new Intent(MeetingQuitSelection.this, MeetingQuitMentee.class);
                QuitAsMenteeIntent.putExtra("email", email);
                QuitAsMenteeIntent.putExtra("password", password);
                QuitAsMenteeIntent.putExtra("phone", phone);
                QuitAsMenteeIntent.putExtra("name", name);
                QuitAsMenteeIntent.putExtra("user", user);
                MeetingQuitSelection.this.startActivity(QuitAsMenteeIntent);
            }
        });


    }
}