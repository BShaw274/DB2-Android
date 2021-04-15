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


public class EditEmailAdmin extends AppCompatActivity {

    EditText etExistEmail;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_email_admin);
        //Gets the values in the EditTextview
        etExistEmail = (EditText) findViewById(R.id.etExistingEmail);
        confirmButton = (Button) findViewById(R.id.confirmButton);
        //Get information passed into this file
        final Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "admin";

        //Confirm button listener
        confirmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String NewEmail = etExistEmail.getText().toString();
                if (NewEmail.matches("")) {
                    Toast.makeText(EditEmailAdmin.this, "You did not enter a email", Toast.LENGTH_SHORT).show();
                    return;
                }

                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                                //Create New intent to go back to he PageAdmin after updating Email
                                Intent intent = new Intent(EditEmailAdmin.this, PageAdmin.class);
                                //Passes values to new activity
                                intent.putExtra("name", name );
                                intent.putExtra("email", NewEmail);
                                intent.putExtra("password", password);
                                intent.putExtra("phone", phone);

                                EditEmailAdmin.this.startActivity(intent);
                    }
                };
                //Uses my EditEmailRequest.java file to pass New and Old Emails to update the account
                EditEmailRequest EditEmailRequest1 = new EditEmailRequest(NewEmail, email, getString(R.string.url) + "EditEmail.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditEmailAdmin.this);
                queue.add(EditEmailRequest1);
            }
        });
        //listener done
    }
}