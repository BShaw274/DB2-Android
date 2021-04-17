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

public class EditSelectStudent extends AppCompatActivity {

    EditText etSelectSEmail;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_select_student);

        //Gets the values in the EditTextview
        etSelectSEmail = (EditText) findViewById(R.id.etSelectSEmail);
        confirmButton = (Button) findViewById(R.id.confirmButton);
        //Get information passed into this file
        final Intent intent = getIntent();
        final String Pname = intent.getStringExtra("name");
        final String Pemail = intent.getStringExtra("email");
        final String Ppassword = intent.getStringExtra("password");
        final String Pphone = intent.getStringExtra("phone");
        final String user = "parent";

        //Confirm button listener
        confirmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String SEmail = etSelectSEmail.getText().toString();
                if (SEmail.matches("")) {
                    Toast.makeText(EditSelectStudent.this, "You did not enter a email", Toast.LENGTH_SHORT).show();
                    return;
                }
                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("pleaseHelp!", response);
                            Log.d("Trying"," Creating JSONObject with: "+ SEmail);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                //Create New intent to
                                Intent intent = new Intent(EditSelectStudent.this, EditStudentInfo.class);
                                intent.putExtra("Pname", Pname );
                                intent.putExtra("Pemail", Pemail);
                                intent.putExtra("Ppassword", Ppassword);
                                intent.putExtra("Pphone", Pphone);
                                intent.putExtra("SEmail", SEmail);

                                EditSelectStudent.this.startActivity(intent);

                            } else{
                                Log.d("Else stmt","In Else stmt !: ");
                                AlertDialog.Builder builder = new AlertDialog.Builder(EditSelectStudent.this);
                                builder.setMessage("Email is not a student of this parent").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                //Uses my EditPasswordRequest.java file to pass New and Old Passwords to update the account
                SelectStudentRequest SelectStudent1 = new SelectStudentRequest(SEmail, Pemail, getString(R.string.url) + "CheckStudent.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditSelectStudent.this);
                queue.add(SelectStudent1);
            }
        });
        //listener done
    }
}