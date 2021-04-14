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


public class EditEmailStudent extends AppCompatActivity {

    EditText etExistEmail;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_email_student);
        //Gets the values in the EditTextview
        etExistEmail = (EditText) findViewById(R.id.etExistingEmail);
        confirmButton = (Button) findViewById(R.id.confirmButton);
        //Get information passed into this file
        final Intent intent = getIntent();
        final String name = intent.getStringExtra("name");
        final String email = intent.getStringExtra("email");
        final String password = intent.getStringExtra("password");
        final String phone = intent.getStringExtra("phone");
        final String user = "student";


        //Confirm button listener
        confirmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String NewEmail = etExistEmail.getText().toString();
                Log.wtf("In onCreate","Here + email "+ NewEmail);
                System.out.println("In onCreate ,Here + email+ NewEmail");
                if (NewEmail.matches("")) {
                    Toast.makeText(EditEmailStudent.this, "You did not enter a email", Toast.LENGTH_SHORT).show();
                    return;
                }

                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("pleaseHelp", response);
                            Log.d("Follow"," theLeader ");
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                Log.d("In IF stmt","In if ");
                                //Create New intent to go back to he PageParent after updating Email
                                Intent intent = new Intent(EditEmailStudent.this, PageStudent.class);
                                //Passes values to the new activity
                                intent.putExtra("name", name );
                                intent.putExtra("email", NewEmail);
                                intent.putExtra("password", password);
                                intent.putExtra("phone", phone);

                                EditEmailStudent.this.startActivity(intent);
                            } else{
                                Log.d("Else stmt","In Else stmt here is success: ");
                                AlertDialog.Builder builder = new AlertDialog.Builder(EditEmailStudent.this);
                                builder.setMessage("New Email is invalid, make sure the email is not already linked to an account.").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                //Uses my EditEmailRequest.java file to pass New and Old Emails to update the account
                EditEmailRequest EditEmailRequest1 = new EditEmailRequest(NewEmail, email, getString(R.string.url) + "EditEmail.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditEmailStudent.this);
                queue.add(EditEmailRequest1);
            }
        });
        //listener done
    }
}