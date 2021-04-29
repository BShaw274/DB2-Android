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

public class EditStudentInfo extends AppCompatActivity {
    //Initializes the editTexts and Buttons
    EditText etSEmail;
    EditText etSPassword;
    EditText etSPhone;
    Button confirmButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_student_info);
        //Set the buttons and text to be equal to the actual values from the activity's layout
        etSEmail = (EditText) findViewById(R.id.etSEmail);
        etSPassword = (EditText) findViewById(R.id.etSPassword);
        etSPhone = (EditText) findViewById(R.id.etSPhone);
        confirmButton = (Button) findViewById(R.id.confirmButton);
        //Get information passed into this file
        final Intent intent = getIntent();
        final String Pname = intent.getStringExtra("Pname");
        final String Pemail = intent.getStringExtra("Pemail");
        final String Ppassword = intent.getStringExtra("Ppassword");
        final String Pphone = intent.getStringExtra("Pphone");
        final String user = "parent";
        final String OldSEmail = intent.getStringExtra("SEmail");

        //Confirm button listener
        confirmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String NewSEmail = etSEmail.getText().toString();
                final String NewSPassword = etSPassword.getText().toString();
                final String NewSPhone = etSPhone.getText().toString();

                Response.Listener<String> responseListener2 = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("pleaseHelp!", response);
                            Log.d("Trying"," Creating JSONObject with Email: "+ NewSEmail+" Pass: "+NewSPassword+" Phone: "+NewSPhone);
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if(success){
                                //Create New intent to
                                Intent intent = new Intent(EditStudentInfo.this, PageParent.class);
                                intent.putExtra("name", Pname );
                                intent.putExtra("email", Pemail);
                                intent.putExtra("password", Ppassword);
                                intent.putExtra("phone", Pphone);

                                EditStudentInfo.this.startActivity(intent);

                            } else{
                                Log.d("Else stmt","In Else stmt !: ");
                                AlertDialog.Builder builder = new AlertDialog.Builder(EditStudentInfo.this);
                                builder.setMessage("Duplicate Email in database, needs to be a unique").setNegativeButton("Retry", null).create().show();
                            }
                        } catch (JSONException e) {
                            Log.d("Catch stmt","We catch these");
                            e.printStackTrace();
                        }

                    }
                };
                //Here we use the request format to access the correct php file while passing the correct variables
                EditAllRequest EditAll1 = new EditAllRequest(OldSEmail, NewSEmail,NewSPassword,NewSPhone, getString(R.string.url) + "EditAll.php", responseListener2);
                RequestQueue queue = Volley.newRequestQueue(EditStudentInfo.this);
                queue.add(EditAll1);
            }
        });
        //listener done
    }
}