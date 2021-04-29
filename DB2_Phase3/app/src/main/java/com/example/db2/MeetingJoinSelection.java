package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MeetingJoinSelection extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meeting_join_selection);
        //Gets info passed from previous intent
        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "parent";
        //Join Button Listener
        Button JoinMentor = (Button) findViewById(R.id.JoinAsMentor);
        JoinMentor.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent JoinAsMentorIntent = new Intent(MeetingJoinSelection.this, MeetingJoinMentor.class);
                JoinAsMentorIntent.putExtra("email", email);
                JoinAsMentorIntent.putExtra("password", password);
                JoinAsMentorIntent.putExtra("phone", phone);
                JoinAsMentorIntent.putExtra("name", name);
                JoinAsMentorIntent.putExtra("user", user);
                MeetingJoinSelection.this.startActivity(JoinAsMentorIntent);
            }
        });
        //Join Button Listener
        Button JoinMentee = (Button) findViewById(R.id.JoinAsMentee);
        JoinMentee.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent JoinAsMenteeIntent = new Intent(MeetingJoinSelection.this, MeetingJoinMentee.class);
                JoinAsMenteeIntent.putExtra("email", email);
                JoinAsMenteeIntent.putExtra("password", password);
                JoinAsMenteeIntent.putExtra("phone", phone);
                JoinAsMenteeIntent.putExtra("name", name);
                JoinAsMenteeIntent.putExtra("user", user);
                MeetingJoinSelection.this.startActivity(JoinAsMenteeIntent);
            }
        });


    }
}