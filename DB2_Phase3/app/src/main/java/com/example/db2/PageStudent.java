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

        TextView tvName = (TextView) findViewById(R.id.tvName);
        TextView tvEmail = (TextView) findViewById(R.id.tvEmail);
        TextView tvPassword = (TextView) findViewById(R.id.tvPassword);
        TextView tvPhone = (TextView) findViewById(R.id.tvPhone);
        Button editEmailButton = (Button) findViewById(R.id.editEmailButton);
        Button editPhoneButton = (Button) findViewById(R.id.editPhoneButton);
        Button editPasswordButton = (Button) findViewById(R.id.editPasswordButton);
        final LinearLayout userLayout = (LinearLayout) findViewById(R.id.userLayout);

        Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "parent";


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


        String title = name + "'s Page";
        tvName.setText(title);
        tvEmail.setText(email);
        tvPhone.setText(phone);


    }
}