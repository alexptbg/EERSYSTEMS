package com.ees.webview;

import com.ees.webview.R;

import android.os.Bundle;//as usual
import android.preference.PreferenceActivity;//instead of a regular Activity

/**
 * @author Alex Soares
 * 01 JUN 2015
 * alex@ka-ex.net
 * color: #597CA2
 * updated: April 2015
**/

public class PrefsActivity extends PreferenceActivity{ //instead of a regular Activity
	
	@Override
	public void onCreate(Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		addPreferencesFromResource(R.xml.prefs);//instead of setContentView()
	}

}

