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

public class PageParent extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_page_parent);

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
            public void onClick(View v) {
                Intent editParentEmailIntent = new Intent(PageParent.this, EditEmailParent.class);
                editParentEmailIntent.putExtra("email", email);
                editParentEmailIntent.putExtra("password", password);
                editParentEmailIntent.putExtra("phone", phone);
                editParentEmailIntent.putExtra("name", name);
                editParentEmailIntent.putExtra("user", user);
                PageParent.this.startActivity(editParentEmailIntent);
            }
            });
        editPhoneButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editParentPhoneIntent = new Intent(PageParent.this, EditPhoneParent.class);
                editParentPhoneIntent.putExtra("email", email);
                editParentPhoneIntent.putExtra("password", password);
                editParentPhoneIntent.putExtra("phone", phone);
                editParentPhoneIntent.putExtra("name", name);
                editParentPhoneIntent.putExtra("user", user);
                PageParent.this.startActivity(editParentPhoneIntent);
            }
        });
        editPasswordButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editParentPasswordIntent = new Intent(PageParent.this, EditPasswordParent.class);
                editParentPasswordIntent.putExtra("email", email);
                editParentPasswordIntent.putExtra("password", password);
                editParentPasswordIntent.putExtra("phone", phone);
                editParentPasswordIntent.putExtra("name", name);
                editParentPasswordIntent.putExtra("user", user);
                PageParent.this.startActivity(editParentPasswordIntent);
            }
        });


        String title = name + "'s Page";
        tvName.setText(title);
        tvEmail.setText(email);
        tvPhone.setText(phone);


    }
}