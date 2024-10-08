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

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class ParentRegistration extends AppCompatActivity {
    //Initializes the editTexts and Buttons
    EditText etNameReg;
    EditText etEmailReg;
    EditText etPhoneReg;
    EditText etPasswordReg;
    Button paRegisterConfirm;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_parent_registration);
        //Set the buttons and text to be equal to the actual values from the activity's layout
        etNameReg = (EditText) findViewById(R.id.etNameReg);
        etEmailReg= (EditText) findViewById(R.id. etEmailReg);
        etPhoneReg = (EditText) findViewById(R.id.etPhoneReg);
        etPasswordReg = (EditText) findViewById(R.id.etPasswordReg);
        paRegisterConfirm = (Button) findViewById(R.id.paRegisterConfirm);



        //Register button listener
        paRegisterConfirm.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                //Making edittext variables into strings.
                String email = etEmailReg.getText().toString();
                String password = etPasswordReg.getText().toString();
                String name = etNameReg.getText().toString();
                String phone = etPhoneReg.getText().toString();


                //If checks to make sure input is not empty.
                if (name.matches("")) {
                    Toast.makeText(ParentRegistration.this, "You did not enter a name", Toast.LENGTH_SHORT).show();
                    return;
                }
                if (email.matches("")) {
                    Toast.makeText(ParentRegistration.this, "You did not enter a email", Toast.LENGTH_SHORT).show();
                    return;
                }
                if (password.matches("")) {
                    Toast.makeText(ParentRegistration.this, "You did not enter a password", Toast.LENGTH_SHORT).show();
                    return;
                }

                if (phone.matches("")) {
                    Toast.makeText(ParentRegistration.this, "You did not enter a phone number", Toast.LENGTH_SHORT).show();
                    return;
                }



                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            Log.d("pleaseHelp", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                //Create New intent to go back to the MainActivity after registering as a parent
                                Intent intent = new Intent(ParentRegistration.this, MainActivity.class);
                                ParentRegistration.this.startActivity(intent);

                            } else{

                                Toast.makeText(ParentRegistration.this, "Failed because data is Invalid", Toast.LENGTH_SHORT).show();
                                AlertDialog.Builder builder = new AlertDialog.Builder(ParentRegistration.this);
                                builder.setMessage("Registration Failed").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                };
                //Here we use the request format to access the correct php file while passing the correct variables
                RegistrationRequest RegistrationRequest1= new RegistrationRequest(email, password, name, phone, getString(R.string.url) + "ParentRegistration.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(ParentRegistration.this);
                queue.add(RegistrationRequest1);
            }
        });
        //listener done
    }
}