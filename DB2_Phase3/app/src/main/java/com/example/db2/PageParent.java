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
        Button editStudentButton = (Button) findViewById(R.id.editStudentButton);
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
        editStudentButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent editSelectStudentIntent = new Intent(PageParent.this, EditSelectStudent.class);
                editSelectStudentIntent.putExtra("email", email);
                editSelectStudentIntent.putExtra("password", password);
                editSelectStudentIntent.putExtra("phone", phone);
                editSelectStudentIntent.putExtra("name", name);
                editSelectStudentIntent.putExtra("user", user);
                PageParent.this.startActivity(editSelectStudentIntent);
            }
        });
        //Get Children Code
        Response.Listener<String> responseListener = new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    Log.d("ChildrenInfo", response);
                    JSONObject jsonResponse = new JSONObject(response);
                    int i = 0;
                    while(jsonResponse.has(Integer.toString(i) + "cid")){
                        Log.d("Gotten Response","Time for Action");
                        String cName = jsonResponse.getString(Integer.toString(i) + "cName");
                        String cEmail = jsonResponse.getString(Integer.toString(i) + "cEmail");
                        String cPhone = jsonResponse.getString(Integer.toString(i) + "cPhone");

                        String temp = "Name: " + cName;
                        String temp2 = "Email: " + cEmail + ", Phone: " + cPhone;
                        TextView userInfo = new TextView(PageParent.this);
                        TextView userInfo2 = new TextView(PageParent.this);
                        userInfo.setText(temp);
                        userInfo2.setText(temp2);
                        userLayout.addView(userInfo);
                        userLayout.addView(userInfo2);
                        userLayout.addView(new TextView(PageParent.this));
                        i++;
                    }
                } catch (JSONException e) {
                    // should not reach here
                    Log.d("whatHappened", response);
                    e.printStackTrace();
                }
            }
        };

        getChildrenRequest getChildren = new getChildrenRequest(email, getString(R.string.url) + "getChildrenInfo.php", responseListener);
        RequestQueue queue = Volley.newRequestQueue(PageParent.this);
        queue.add(getChildren);
        //Finish get Children code
        String title = name + "'s Page";
        tvName.setText(title);
        tvEmail.setText(email);
        tvPhone.setText(phone);


    }
}