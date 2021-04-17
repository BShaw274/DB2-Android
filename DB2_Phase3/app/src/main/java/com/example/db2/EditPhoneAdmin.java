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


public class EditPhoneAdmin extends AppCompatActivity {

    EditText etExistPhone;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_phone_admin);
        // Gets the values from the Text view Fields
        etExistPhone = (EditText) findViewById(R.id.etExistingPhone);
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
                final String NewPhone = etExistPhone.getText().toString();
                if (NewPhone.matches("")) {
                    Toast.makeText(EditPhoneAdmin.this, "You did not enter a phone number", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        //Create New intent to go back to he PageAdmin after updating Phone
                        Intent intent = new Intent(EditPhoneAdmin.this, PageAdmin.class);

                        intent.putExtra("name", name );
                        intent.putExtra("email", email);
                        intent.putExtra("password", password);
                        intent.putExtra("phone", NewPhone);
                        //Create New intent to go back to he PageAdmin after updating Email
                        EditPhoneAdmin.this.startActivity(intent);
                    }
                };
                //Uses my EditPhoneRequest.java file to pass New and Old Phones to update the account
                EditPhoneRequest EditPhoneRequest1 = new EditPhoneRequest(NewPhone, email, getString(R.string.url) + "EditPhone.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditPhoneAdmin.this);
                queue.add(EditPhoneRequest1);
            }
        });
        //listener done
    }
}