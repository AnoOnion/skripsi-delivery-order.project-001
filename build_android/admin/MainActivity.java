package com.adminsanqua.app;

import android.os.Bundle;

import com.getcapacitor.BridgeActivity;
import com.codetrixstudio.capacitor.GoogleAuth.GoogleAuth;
import com.getcapacitor.community.facebooklogin.FacebookLogin;

public class MainActivity extends BridgeActivity {
    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);

        registerPlugin(GoogleAuth.class);
        registerPlugin(FacebookLogin.class);
    }
}
