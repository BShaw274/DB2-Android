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

public class StudentRegistration extends AppCompatActivity {
    EditText etNameReg;
    EditText etEmailReg;
    EditText etPhoneReg;
    EditText etPasswordReg;
    Button stRegisterConfirm;
    EditText etParentEmail;
    EditText etGrade;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student_registration);

        etNameReg = (EditText) findViewById(R.id.etNameReg);
        etEmailReg= (EditText) findViewById(R.id. etEmailReg);
        etPhoneReg = (EditText) findViewById(R.id.etPhoneReg);
        etPasswordReg = (EditText) findViewById(R.id.etPasswordReg);
        etParentEmail= (EditText) findViewById(R.id.etParentEmail);
        etGrade= (EditText) findViewById(R.id.etGrade);
        stRegisterConfirm = (Button) findViewById(R.id.stRegisterConfirm);


        //Confirm button listener
        stRegisterConfirm.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                //Making edittext variables into strings.
                String email = etEmailReg.getText().toString();
                String password = etPasswordReg.getText().toString();
                String name = etNameReg.getText().toString();
                String phone = etPhoneReg.getText().toString();
                String paEmail = etParentEmail.getText().toString();
                String grade = etGrade.getText().toString();

                //Debug statement
                //Log.d("TestEmail", "Email: " + email);
                Log.d("TestEmail", "Email: " + email);
                Log.d("password", "password: " + password);
                Log.d("name", "name: " + name);
                Log.d("Phone:", "phone: " + phone);
                Log.d("paEmail", "paEmail: " + paEmail);
                Log.d("Grade", "Grade: " + grade);


                //If checks to make sure input is not empty.
                if (name.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a name", Toast.LENGTH_SHORT).show();
                    return;
                }
                if (email.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a email", Toast.LENGTH_SHORT).show();
                    return;
                }
                if (password.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a password", Toast.LENGTH_SHORT).show();
                    return;
                }

                if (phone.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a phone number", Toast.LENGTH_SHORT).show();
                    return;
                }

                if (paEmail.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a parent Email", Toast.LENGTH_SHORT).show();
                    return;
                }

                if (grade.matches("")) {
                    Toast.makeText(StudentRegistration.this, "You did not enter a grade", Toast.LENGTH_SHORT).show();
                    return;
                }
                int gradetoint =Integer.parseInt(grade);

                if (gradetoint< 6 || gradetoint >12){
                    Toast.makeText(StudentRegistration.this, "You did not enter a valid grade. Please enter between 6 and 12", Toast.LENGTH_SHORT).show();
                    return;
                }

                Log.d("GradetoInteger", "GradetoInteger: " + gradetoint);



                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("pleaseHelp", response);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                //Create New intent to go back to the MainActivity after registering as a parent
                                Intent intent = new Intent(StudentRegistration.this, MainActivity.class);
                                StudentRegistration.this.startActivity(intent);

                            } else{

                                Toast.makeText(StudentRegistration.this, "Failed because data is Invalid", Toast.LENGTH_SHORT).show();
                                AlertDialog.Builder builder = new AlertDialog.Builder(StudentRegistration.this);
                                builder.setMessage("Registration Failed").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }



                    }
                };
                //Uses my RegistrationRequest to execute php file and update database
                StudentRegistrationRequest StudentRegistrationRequest1= new StudentRegistrationRequest(email, password, name, phone, paEmail, grade, getString(R.string.url) + "StudentRegistration.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(StudentRegistration.this);
                queue.add(StudentRegistrationRequest1);
            }
        });
        //listener done

    }
}