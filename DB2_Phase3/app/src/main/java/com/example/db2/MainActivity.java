package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Admin Sign in Link
        Button adSignInButton = (Button) findViewById(R.id.adSignInButton);
        adSignInButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent adSignInIntent = new Intent(MainActivity.this, SignInAdmin.class);
                MainActivity.this.startActivity(adSignInIntent);
            }
        });

        // Parent Sign in Link

        Button paSignInButton = (Button) findViewById(R.id.paSignInButton);
        paSignInButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent paSignInIntent = new Intent(MainActivity.this, SignInParent.class);
                MainActivity.this.startActivity(paSignInIntent);
            }
        });

        // Parent Sign in Link

        Button stSignInButton = (Button) findViewById(R.id.stSignInButton);
        stSignInButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent stSignInIntent = new Intent(MainActivity.this, SignInStudent.class);
                MainActivity.this.startActivity(stSignInIntent);
            }
        });

        Button paRegisterButton = (Button) findViewById(R.id.paRegisterButton);
        paRegisterButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent paRegisterIntent = new Intent(MainActivity.this, ParentRegistration.class);
                MainActivity.this.startActivity(paRegisterIntent);
            }
        });

        Button stRegisterButton = (Button) findViewById(R.id.stRegisterButton);
        stRegisterButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent stRegisterIntent = new Intent(MainActivity.this, StudentRegistration.class);
                MainActivity.this.startActivity(stRegisterIntent);
            }
        });



    }
}
