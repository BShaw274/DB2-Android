package com.example.db2;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class SignInParent extends AppCompatActivity {
    //Initializes the editTexts and Buttons
    EditText etEmail;
    EditText etPassword;
    Button signInButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_in_parent);

        //Set the buttons and text to be equal to the actual values from the activity's layout
        etEmail = (EditText) findViewById(R.id.email);
        etPassword = (EditText) findViewById(R.id.password);
        signInButton = (Button) findViewById(R.id.signInButton);

        //signIn button listener
        signInButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                String email = etEmail.getText().toString();
                String password = etPassword.getText().toString();
                Response.Listener<String> responseListener = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("pleaseHelp", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                String name = jsonResponse.getString("name");
                                String email = jsonResponse.getString("email");
                                String password = jsonResponse.getString("password");
                                String phone = jsonResponse.getString("phone");

                                //gets the strings back from the php file
                                Intent intent = new Intent(SignInParent.this, PageParent.class);
                                intent.putExtra("name", name);
                                intent.putExtra("email", email);
                                intent.putExtra("password", password);
                                intent.putExtra("phone", phone);

                                SignInParent.this.startActivity(intent);
                            } else{
                                AlertDialog.Builder builder = new AlertDialog.Builder(SignInParent.this);
                                builder.setMessage("Sign In Failed").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                };
                //Here we use the request format to access the correct php file while passing the correct variables
                SignInRequest signInRequest = new SignInRequest(email, password,getString(R.string.url) + "ParentSignIn.php", responseListener);
                RequestQueue queue = Volley.newRequestQueue(SignInParent.this);
                queue.add(signInRequest);
            }

        });


    }
}