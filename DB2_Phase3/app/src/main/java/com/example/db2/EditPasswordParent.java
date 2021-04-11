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

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


public class EditPasswordParent extends AppCompatActivity {

    EditText etExistPassword;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_password_parent);
        //Gets the values in the EditTextview
        etExistPassword = (EditText) findViewById(R.id.etExistingPassword);
        confirmButton = (Button) findViewById(R.id.confirmButton);
        //Get information passed into this file
        final Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "parent";

        //Confirm button listener
        confirmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String NewPassword = etExistPassword.getText().toString();

                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        //Create New intent to go back to he PageParent after updating Password
                        Intent intent = new Intent(EditPasswordParent.this, PageParent.class);

                        intent.putExtra("name", name );
                        intent.putExtra("email", email);
                        intent.putExtra("password", NewPassword);
                        intent.putExtra("phone", phone);

                        EditPasswordParent.this.startActivity(intent);
                    }
                };
                //Uses my EditPasswordRequest.java file to pass New and Old Passwords to update the account
                EditPasswordRequest EditPasswordRequest1 = new EditPasswordRequest(NewPassword, email, getString(R.string.url) + "EditPassword.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditPasswordParent.this);
                queue.add(EditPasswordRequest1);
            }
        });
        //listener done
    }
}